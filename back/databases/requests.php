<?php

class db{
    /* This class is here to make your db interaction faster
    Each table of your database can have its own instance of this class

    How to create an instance of the class : 

    // Let's imagine our database Players with the table user.
    $Users = new db($conn,'user','username',['username','anotherColumn']);

    //The $conn is your connection instance and must be created before.
    // The 'user' is my table name.
    // The 'username' is the primary key of my table. this doesn't have to be called username or id everytime. 
    // If you don't enter the primary key, you may have error if two datas are not unique.

    How to use the class :

    //Folowing our user exemple, if i want all the datas of the user with the primary key (ex, username) being CoolUser19
    $myUser = 'CoolUser19';
    $fetched_data = $User->request($myUser); //For those who are asking, what is $User, please read the doc again
    //To display my username :
    echo $fetched_data['username']; //The name between ' must be a valid key.

    / -------------------------------- \
    More info on the class :
    Private variables :

    mainTable : Table choosed in the constructor.
    conn : The connection given.
    primaryKey : The key given.
    columns : This will contains the columns list of the database. It's a mesure against SQLInjection.

    Function of the class:

    - __construct (public)
    - request (public)
    - request_if (public)
    - add_with (public)
    - change_if (public)
    - delete (public)
    - request_all (public)
    - request_if_null (public)
    - request_if_in_order (public)

    \ -------------------------------- /

    */

    private $mainTable;
    private $conn;
    private $primaryKey;
    private $columns; //This will be the array containing all the column of the class

    //CONSTRUCTOR
    public function __construct($connectionInfo, $table, $primaryKey_, array $columnsList){
        $this->mainTable = $table;
        $this->conn = $connectionInfo;
        $this->primaryKey = $primaryKey_;
        $this->columns = $columnsList;
    }



    public function request($id, $verbose = false, $details = false){
        /* Return the line corresponding to the parameter (can lead to fatal error if not unique)
        ARGS : id, verbose=false, details=false
        - Fetched : YES

        In case of failure, return an empty array
        Verbose will display informations about the failure
        Details will display informations about the queries
        */

        try {
        $query = "SELECT * FROM ".$this->mainTable." WHERE ".$this->primaryKey." = ?;";
        if($details)
            echo "<br>Requested query : ".$query."<br>ID is ".$id;

        $request = ($this->conn)->prepare($query);
        if($details)
            echo "<br>The prepare is done";

        $request->bindParam(1, $id); 
        if($details)
            echo "<br>ID bind successfull"; 

        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);
        if($details)
            echo "<br>Request executed and fetched<br>"; 
        
        
        return $result;

        }
        catch(PDOException $e){
            throw new Exception("Error in add_with : Request failed" . $e->getMessage());
        }
    }


    public function request_if($column,$value,$verbose=false,$details=false){
        /* Return an array of array containing all the lines (fetched) of the database that valide the condition
        ARGS : column,value,verbose=false,details=false
        - Fetched : YES

        In case of failure, return an empty array
        Verbose will display informations about the failure
        Details will display informations about the queries
        Warning : This will not work to check if a column is null. Please use the request_if_null function instead
        */

        if(!in_array($column,$this->columns)){
            throw new Exception("Error in request_if, Invalid column :" . $column  );
            return [];
        }
    
        try {
            
            $query = "SELECT * FROM ".$this->mainTable." WHERE ".$column." = ?;";
            if($details)
            echo "<br>Requested query : ".$query."<br>The column to check the condition on is ".$column." and the condition is =".$value;

            $request = ($this->conn)->prepare($query);
            if($details)
                echo "<br>The prepare is done";

            $request->bindParam(1, $value); 
            if($details)
                echo "<br>".$value." bind successfull"; 

            $request->execute();

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return $result;
        }
        catch(PDOException $e){
            throw new Exception("Error in request_if : Request failed. Infos : " . $e->getMessage());
            return [];            
        } 
    }

    public function add_with($values,$verbose=false,$details=false){
        /* Will add a line in the database with the give values. The given values must be in an dictionnary and in order they want to be inserted
        ARGS : $values,verbose=false,$details=false
        - Fetched : NaN

        Exemple of call :
        $myDatas = [
            "data1" => 1, "data2" => 2            
        ];
        $success = MyDatabase.add_with($myDatas,false,true);
        if($success){
            ... //Code when the datas are added
        }


        In case of failure, return false and throw an exception, and if case of success, return true
        Verbose will display informations about the failure
        Details will display informations about the queries
        */

        foreach(array_keys($values) as $column){
            if(!in_array($column,$this->columns)){
                throw new Exception("Error in add_with, Invalid column :" . $column  );
            }
        }


        try {

            // get the columns
            $columns = array_map(fn($col) => '"' . $col . '"', array_keys($values)); //here, this will add "" to every column. I did this because they may have conflict with SQL keywords, like END.

            
            // get the values
            $datas = array_values($values);
            

            $placeholders = array_fill(0, count($datas), '?'); //This auto create the ? for the request !


            $query = "INSERT INTO ".$this->mainTable." (".implode(',',$columns).") VALUES (".implode(',', $placeholders).");"; //the implode will cut my array into the values !
            
            
            if($details)
            echo "<br>Requested query : ".$query;

            $request = ($this->conn)->prepare($query);
            $request->execute($datas); //The execute take $datas to auto-bind
    

            if($details)
                echo "<br>Request executed !"; 
            
            
            return true;
            
        }
        catch(PDOException $e){
            throw new Exception("Error in add_with : Request failed. Infos :" . $e->getMessage());
        } 
    }


    public function change_if($id,$column,$value,$verbose=false,$details=false){
        /* Change the value of a given column for a given id
        ARGS : id,column,value,verbose=false,details=false
        - Fetched : NaN

        In case of failure, return false, and in case of success, return true
        Verbose will display informations about the failure
        Details will display informations about the queries
        */
        if(!in_array($column,$this->columns)){
            throw new Exception("Error in change_if, Invalid column :" . $column);

            return false;
        }


        try {
            
            $query = "UPDATE ".$this->mainTable." SET ".$column." = ? WHERE ".$this->primaryKey." = ?;";
            if($details)
                echo "<br>Requested query : ".$query." (Parameters are : ".$value.", ".$id.")";

            $request = ($this->conn)->prepare($query);
            $request->execute([$value,$id]); //Autobind

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return true;
        }
        catch(PDOException $e){
            throw new Exception("Error in change_if : Request failed. Infos : " . $e->getMessage());
            return false;            
        } 
    }


    public function delete($id,$verbose=false,$details=false){
        /* Remove the line matching the given primary key. Note that if you dont use the primary key, you may have unexpected results.
        ARGS : id,verbose=false,details=false
        - Fetched : NaN

        Return true if the process worked, and false if not. Note that a true is just no error in the database, so maybe the delete was not done properly, it's up to you to check after
        Verbose will display informations about the failure
        Details will display informations about the queries
        */
        try {
            
            $query = "DELETE FROM ".$this->mainTable." WHERE ".$this->primaryKey." = ?;";
            if($details)
            echo "<br>Requested query : ".$query."<br>The ID is ".$id.".";

            $request = ($this->conn)->prepare($query);
            if($details)
                echo "<br>The prepare is done";

            $request->execute([$id]);

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return true;
        }
        catch(PDOException $e){
            throw new Exception("Error in delete : Request failed. Infos : " . $e->getMessage());

            return false;            
        } 
    }



    public function request_all($verbose = false, $details = false){
        /* Return the entire table in a list of dictionnary (basically do a request on each line)
        ARGS : verbose=false, details=false
        - Fetched : YES

        Verbose will display informations about the failure
        Details will display informations about the queries
        */

        try {
        $query = "SELECT * FROM ".$this->mainTable.";";
        if($details)
            echo "<br>Requested query : ".$query;

            
        $request = ($this->conn)->prepare($query);

        $request->execute();


        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        if($details)
            echo "<br>Request executed and fetched<br>"; 
        
        
        return $result;

        }
        catch(PDOException $e){
            if($verbose)
                echo "Error on request function : ".$e->getMessage();
            return [];
        }
    }


    public function request_if_null($column,$verbose=false,$details=false){
        /* Return an array of array containing all the lines (fetched) of the database where the column is null
        ARGS : column,verbose=false,details=false
        - Fetched : YES

        In case of failure, return an empty array
        Verbose will display informations about the failure
        Details will display informations about the queries
        Warning : This work only for null (not the text null but the value null)
        */

        if(!in_array($column,$this->columns)){
            if($verbose){
                echo "<br>The column '".$column."' was not set as a valid column by your admin. If this is not normal, check the database definition in your code.";
            }
            return [];
        }
    
        try {
            
            $query = "SELECT * FROM ".$this->mainTable." WHERE ".$column." is null;";
            if($details)
            echo "<br>Requested query : ".$query."<br>The column to check the condition on is ".$column;

            $request = ($this->conn)->prepare($query);
            if($details)
                echo "<br>The prepare is done";


            $request->execute();

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return $result;
        }
        catch(PDOException $e){
            if($verbose)
                echo "Error on request_if function : ".$e->getMessage();
            return [];            
        } 
    }

    public function request_in_order($sortColumn,$asc=true,$verbose=false,$details=false){
        /* Return an array of array containing all the lines (fetched) of the database in order
        Will sort using the $sortColumn values. 
        ARGS : sortColumn,asc=true,verbose=false,details=false
        - Fetched : YES

        In case of failure, return an empty array
        Verbose will display informations about the failure
        Details will display informations about the queries
        Warning : This will not work to check if a column is null. Please use the request_if_null function instead
        */


        if(!in_array($sortColumn,$this->columns)){
            if($verbose){
                echo "<br>The column '".$sortColumn."' was not set as a valid column by your admin. If this is not normal, check the database definition in your code.";
            }
            return [];
        }
    
        try {
            $ascOrDesc = "asc";
            if($asc == false){
                $ascOrDesc = "desc";
            }


            $query = "SELECT * FROM ".$this->mainTable." ORDER BY ".$sortColumn." ".$ascOrDesc;
            if($details)
            echo "<br>Requested query : ".$query." the condition is =".$value;

            $request = ($this->conn)->prepare($query);
            if($details)
                echo "<br>The prepare is done";

            $request->execute();

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return $result;
        }
        catch(PDOException $e){
            if($verbose)
                echo "Error on request_if function : ".$e->getMessage();
            return [];            
        } 
    }


    public function request_if_in_order($column,$value,$sortColumn,$asc=true,$verbose=false,$details=false){
        /* Return an array of array containing all the lines (fetched) of the database that valide the condition in order
        Will sort using the $sortColumn values. 
        ARGS : column,value,sortColumn,asc=true,verbose=false,details=false
        - Fetched : YES

        In case of failure, return an empty array
        Verbose will display informations about the failure
        Details will display informations about the queries
        Warning : This will not work to check if a column is null. Please use the request_if_null function instead
        */

        if(!in_array($column,$this->columns)){
            if($verbose){
                echo "<br>The column '".$column."' was not set as a valid column by your admin. If this is not normal, check the database definition in your code.";
            }
            return [];
        }
        if(!in_array($sortColumn,$this->columns)){
            if($verbose){
                echo "<br>The column '".$sortColumn."' was not set as a valid column by your admin. If this is not normal, check the database definition in your code.";
            }
            return [];
        }
    
        try {
            $ascOrDesc = "asc";
            if($asc == false){
                $ascOrDesc = "desc";
            }


            $query = "SELECT * FROM ".$this->mainTable." WHERE ".$column." = ? ORDER BY ".$sortColumn." ".$ascOrDesc;
            if($details)
            echo "<br>Requested query : ".$query."<br>The column to check the condition on is ".$column." and the condition is =".$value;

            $request = ($this->conn)->prepare($query);
            if($details)
                echo "<br>The prepare is done";

            $request->bindParam(1, $value); 
            if($details)
                echo "<br>".$value." bind successfull"; 

            $request->execute();

            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            if($details)
                echo "<br>Request executed and fetched"; 
            
            
            return $result;
        }
        catch(PDOException $e){
            if($verbose)
                echo "Error on request_if function : ".$e->getMessage();
            return [];            
        } 
    }
}

?>