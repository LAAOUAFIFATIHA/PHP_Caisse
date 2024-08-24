<!DOCTYPE html>
<html lang="en">
<head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>BOOKSTORE</title>
<?php
//la connection
$conn= new mysqli("localhost" ,"root" ,"", "books");
if($conn->connect_error){
         die("connection failed".$conn==connect_error);
}

if(isset($_GET['idannulle'])){
  $sql=" DELETE FROM `achat` WHERE id=".$_GET['idannulle']." ";
  $conn -> query($sql);

}
function getLastIdcommande($conn){
  $sql = "SELECT `idCommande` FROM `achat` ORDER BY `achat`.idCommande DESC LIMIT 1;";
  $id = $conn -> query($sql);
  $row = $id->fetch_assoc();
  return $row["idCommande"];
}
if(isset($_GET['idCommande'])){
  $idCommande = $_GET['idCommande'];
}
else {
  $idCommande = getLastIdcommande($conn);
}


function getname( $id,$conn){
  if (empty($id)) {
    return "Invalid ID"; // or handle this case accordingly
}
  $sql="SELECT  `nomBook` FROM `books` WHERE id=". $id."";
  $nomBook = $conn-> query($sql);
  $row = $nomBook ->fetch_assoc();
  return($row['nomBook']);}
function getprice($id,$conn){
  $sql = "SELECT `prix` FROM `books` WHERE id=".$id."";
  $price = $conn-> query($sql);
  $row = $price->fetch_assoc();
  return($row['prix']);
}

if(isset($_POST['codeBook'])){
   
    $id = $_POST['codeBook'];
    $quantite = $_POST['quantiteBook'];
    $sql = "INSERT INTO `achat` (`id`, `nomBook`, `quantite`, `prix`,`idCommande`)  
            VALUES ('".$id."', '". getname($id, $conn)."', '".$quantite."', '".getprice($id, $conn)."' ,'". $idCommande ."');";
    $conn->query($sql);
  }

if(isset($_POST['nameBook'])){
    $NAME = $_POST['nameBook'];
    $PRIX = $_POST['prix'];
    $sql = "INSERT INTO `books` (`nomBook`, `prix`)  
            VALUES ('".$NAME."', '". $PRIX."');";
    $conn->query($sql);
  }
if(isset($_POST['book'])){
    $book = $_POST['book'];
    
    $sql = "INSERT INTO `images` (`image`)  
            VALUES ('".$book."');";
    $conn->query($sql);
  }



?>


<style>

BODY{
    color: black;
    /* background-color: aliceblue; */
    margin: 20px 40px 20px 30px;
    padding:5px 40px 20px 30px;
    width:20px 70px 20px 30px ;
    background-position-x: center;
    background : linear-gradient(180deg ,   #f3f1f5, #151516  );}
main{
        color: black;
        margin: 20px 40px 20px 30px;
        padding:5px 40px 20px 30px;
        width:20px 70px 20px 30px ;
        background-position-x: center;
}
/* h1{
    background-color:#007b6f ;
    text-shadow:20px;
    border-width: 20px 30px 20px 20px;
    margin: 0px 250px 0px 300px;
    padding:0px 60px 0px 300px;
} */


h1{
    background-color : black;
    -webkit-background-clip:text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 50px;
    font-style:oblique ;
    margin: 0px 250px 0px 100px;
    padding:0px 60px 0px 300px;
}



h3{
    size: 50px;
}
#bor{
  text-align: center;
  border: solid;
  box-sizing: 1px;
}

.GLOBALE {
    display: flex;
    
}
.DIV1 {
    flex: 1;
    border: 3px solid;
    border-radius: 30px;
    border-color:linear-gradient(90deg , #26f5ai , #f3eb24,#ma1ahb );
    background: linear-gradient(90deg ,#00ffbb ,#ff006f);
    padding: 40px ;
    margin: 20px ;
  
    /* background:#a6b1f0; */

}
.DIV2 {
    flex: 7;
    border: 3px solid;
    border-radius: 30px;
    border-color:linear-gradient(90deg , #26f5ai , #f3eb24,#ma1ahb );
    padding: 40px ;
    margin: 20px;
    /* background:#a6b1f0; */
    background: linear-gradient(90deg ,#00ffbb ,#ff006f);
    
}

input ,select{
    padding: 10px;
    border: 3px solid black;
    border-radius: 8px;
    background-repeat: no-repeat;
    background-size: 20px; 
    background-position: 95% center;
}

input[type="submit"] {
    background-color: black;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
.bouton{
    background-color: black;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
#space_padding_margin {
    padding: 20px 30px;
    margin: 30px 10px ;
}

span{
  color:red;
font-size :20px;

}


</style>


<link rel="stylesheet" href="filecss.css"  type="text/css"/>
</head>

<!--**********************fin**************************-->



</head>
<body>
         <h1> Welcome To My Bookstore </h1><br><br>


<div class="GLOBALE">
      <div class="DIV1" id="space_padding_margin "> 
        <h2>Acheter  the books :</h2>
                          
                                 <form action="#" method="post">
                                    
                                    <input type="number" name="codeBook" id ="codeBook" placeholder="code of book">
                                    <br><br>
                                    <input type="number" name="quantiteBook" id ="quantiteBook" placeholder="quantite of books"><br><br>
                                    <input type="submit" value="save"    class = "bouton">
                                  </form><br><br><br><br><br>
                  
                          
                                  <h2> Commmande <?php $idCommande ?></h4><br>
                                  <form action="#" method="GET">

                                    <select class="form-select" name="idCommande" id="idCommande" aria-label="Default select example">

                          <?php
                                    $sql = "SELECT distinct idCommande FROM `achat` ";
                                    $listAchat = $conn->query($sql);
                                    
                                    if ($listAchat->num_rows > 0) {
                                    // output data of each row
                                        while($row = $listAchat->fetch_assoc()) {
                                        echo '<option value="'.$row["idCommande"].'"> Commande :'.$row["idCommande"].'</option>';
                                        }
                                    }
                          ?>
                                    </select><br><br>
                        <input type="submit" class="btn btn-primary" value="save" /> 

</form>
                                  
                           
                                          <!-- <a href="caisse.php?idCommande=<?php getLastIdcommande($conn)+1?>">new Commande</a> -->
                                          <h3> <a href="caisse.php?idCommande=<?php echo getLastIdcommande($conn)+1?>"> New Commande</a> </h3>
                                         
        </div>


 <!--"""""""""""""""""""""table achat """""""""""""""""""""--> 
      <div class="DIV1" id="space_padding_margin "> 
                <h2>Liste Of Achats Of Commande <?php echo $idCommande ?> </h2>
        
                                    <table BORDER ="2">
                                    <tr >
                                             <td class ="th"><h5>action</h5></td>
                                             <td class ="th"><h5>id</h5></td>
                                             <td class ="th"><h5>image</h5></td>
                                             <td class ="th"><h5>price</h5></td>
                                             <td class ="th"><h5>name</h5></td>
                                             <td class ="th"><h5>quantite</h5></td>
                                    </tr>        
  
                <?php
             
                $somme = 0;
                                    $sql="SELECT * FROM `achat` WHERE `idCommande` =".$idCommande."  ";
                                    $listAchat=$conn->query($sql);
                                    if($listAchat->num_rows > 0){
                                             while($row = $listAchat->fetch_assoc()){
                                                      echo "<tr><td><a href=caisse.php?idannulle=".$row['id']."><u>annule</u></h5></td>
                                                                <td><h5>".$row['id']."</h5></td>
                                                                <td><h5><img src=image/".$row['id'].".png png width=30% height=30%></h5></td>
                                                                <td><h5>".$row['prix']."</h5></td>
                                                                <td><h5>".$row['nomBook']."</h5></td>
                                                                <td><h5>".$row['quantite']."</h5></td>
                                                              
                                                           </tr>";
                                                          $somme+= $row['prix']*$row['quantite'];}}
                                    else { echo"cette commande set vide "; }
                
                                                echo"<tr>
                                                    <td colspan =3 ><H3>LA SOMME</H3></td>
                                                    <td  colspan =3 ><h3>".$somme."</h3></td>
                                                </tr>";
                ?>
                           </table>        
        </div>
</div>



<div class="GLOBALE">
      <div class="DIV1" id="space_padding_margin "> 
                  
          <!--"""""""""""""""""""""table of books"""""""""""""""""""""-->
                        <h2>Liste Of Books</h2>
                           <table BORDER="2">
                                    <tr>
                                             <td><h3>id</h3></td>
                                             <td><h3>image</h3></td>
                                             <td><h3>name </h3></td>
                                             <td><h3>price</h3></td>
       
                                    </tr>
                           <?php
                           $sql="SELECT * FROM `books`";
                           $listBooks = $conn->query($sql);
                           $sql="SELECT * FROM `images`";
                           $listimages = $conn->query($sql);
                           if($listBooks->num_rows > 0){
                                    while($row=$listBooks->fetch_assoc() and $rowi=$listimages->fetch_assoc() ){
                                     echo "<tr>
                                             <td><h5>".$row["id"]."</h5></td>
                                             <td><img src=".$rowi["image"]." width=30% height=30%></td>
                                             
                                             <td><h5>".$row["nomBook"]."</h5></td>
                                             <td><h5>".$row["prix"]."</h5></td>
                                           </tr>";
                                           

                                    }}

                           ?>
                            </table>

         </div>

          <div class="DIV1" id="space_padding_margin "> 

            <form action="#" method="post">
            <p> 
            <h2>paiement :</h2> <input type="number"  class="form-control" name="paiement" id="paiement" /> <br><br>
            <input type="submit" value="save"   class = "bouton"/> </p>
            </form><br><br>
<?php
            $pieces = array(200, 100, 50, 20,10,5,2,1);
            $paiement=0;
            if(isset($_POST["paiement"]))
            $paiement=$_POST["paiement"];
            {
                if($paiement<$somme)
                echo " ajouter d'autre pieces";
                else
                {
                $rest=$paiement-$somme;
                echo $rest."Dh =";
                $acc =1; 
                  
                    $f =0 ;
                    for ($j=0 ; $j<count($pieces) ; $j++)
                    {
                        if ($pieces[$j] <= $rest){
                          if ($f != 0 ){
                            if ( $old == $pieces[$j])
                                {  $acc = $acc +1 ; }
                            else{
                              echo "~~<span>".$acc." </span>de ".$old."Dh";
                              $old =$pieces[$j] ;
                              $acc = 1 ;}}

                          $rest=$rest-$pieces[$j];
                          $old =$pieces[$j] ;
                          $j=$j-1;
                          $f = $f + 1 ;
                              
                            }
                       
                        } 
                        if ($old){
                          echo "~~<span>".$acc." </span>de ".$old."Dh";
                          
                  }}}
            
            ?>



            <h2>Add Somme Products : </h2>
            <form action="#"   method="post">
              <input type="text" name ="nameBook" id ="nameBook" placeholder = "name of book"><br><br>
              <input type="number" name ="prix" id = "prix" placeholder="prix"><br><br>
              <input type="text" name ="book" id = "book" placeholder ="expport fille"><br><br>
              <input type="submit" value="save">

            </form>
                   
          </div>
  
</div>
         
</body>

</html>