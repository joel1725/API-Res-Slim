<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET ALL CUSTOMER
$app->get('/api/customers', function (Request $request, Response $response){
    $sql = "SELECT * FROM customers";
    
    try{
        //GET DE DB OBJECT
        $db = new db();
        //CONNECT DE DATA BASE
        $db = $db->connect();
        
        //CREAMOS EL QUERY A SOLICITAR
        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($customers);
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//GET A SINGLE CUSTOMER
$app->get('/api/customer/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id =$id";
    
    try{
        //GET DE DB OBJECT
        $db = new db();
        //CONNECT DE DATA BASE
        $db = $db->connect();
        
        //CREAMOS EL QUERY A SOLICITAR
        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($customer);
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//ADD A CUSTOMER
$app->post('/api/customer', function (Request $request, Response $response){
    $firstName = $request->getParam('firstName');
    $lastName = $request->getParam('lastName');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    $sql = "INSERT INTO customers (firstName, lastName, phone, email, address, city, state) VALUES (:firstName, :lastName, :phone, :email, :address, :city, :state)";
    
    try{
        //GET DE DB OBJECT
        $db = new db();
        //CONNECT DE DATA BASE
        $db = $db->connect();
        
        //CREAMOS EL QUERY A SOLICITAR
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        
        $stmt->execute();
        
        echo '{"notice": {"text": "Customer added"}';
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
    
    //RECIBE UN ARCHIVO JSON COMO EL QUE SIGUE
    /*
    {
      "firstName":"NOMBRE NUEVO",
      "lastName":"APELLODIDO NUEVO",
      "phone":"809-456-0982",
      "email":"NUEVO@CORREO.COM",
      "address":"NUEVA DIRECCION",
      "city":"NUEVA CIUDAD",
      "state":"NUEVO ESTADO"
    }
    */
});



//UPDATE A CUSTOMER
$app->put('/api/customer/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $firstName = $request->getParam('firstName');
    $lastName = $request->getParam('lastName');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    $sql = "UPDATE customers SET 
                firstName   =   :firstName,
                lastName    =   :lastName,
                phone       =   :phone,
                email       =   :email,
                address     =   :address,
                city        =   :city,
                state       =   :state
            WHERE id = $id";
    
    try{
        //GET DE DB OBJECT
        $db = new db();
        //CONNECT DE DATA BASE
        $db = $db->connect();
        
        //CREAMOS EL QUERY A SOLICITAR
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        
        $stmt->execute();
        
        echo '{"notice": {"text": "Customer updated"}';
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
    
    //RECIBE UN ARCHIVO JSON COMO EL QUE SIGUE
    /*
    {
      "firstName":"NOMBRE NUEVO",
      "lastName":"APELLODIDO NUEVO",
      "phone":"809-456-0982",
      "email":"NUEVO@CORREO.COM",
      "address":"NUEVA DIRECCION",
      "city":"NUEVA CIUDAD",
      "state":"NUEVO ESTADO"
    }
    */
});


//DELETE ALL CUSTOMER
$app->delete('/api/customer/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM customers WHERE id = $id";
    
    try{
        //GET DE DB OBJECT
        $db = new db();
        //CONNECT DE DATA BASE
        $db = $db->connect();
        
        //CREAMOS EL QUERY A SOLICITAR
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        echo '{"notice": {"text": "Customer deleted"}';
        
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



