<?php
if(isset($_POST['emailsubscibe']))
{
$subscriberemail=$_POST['subscriberemail'];
$sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$query= $dbh -> prepare($sql);
$query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<script>alert('Already Subscribed.');</script>";
}
else{
$sql="INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
$query = $dbh->prepare($sql);
$query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Subscribed successfully.');</script>";
}
else
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <h6>À propos de nous</h6>
          <ul>


          <li><a href="page.php?type=aboutus">À propos de nous</a></li>
            <li><a href="page.php?type=faqs">FAQs</a></li>
            <li><a href="page.php?type=privacy">confidentialité</a></li>
          <li><a href="page.php?type=terms">Termes d'utilisation</a></li>
               <li><a href="admin/">Admin Login</a></li>
          </ul>
        </div>

        <div class="col-md-3 col-sm-6">
          <h6>Abonner Newsletter</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Enter Email Address" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block">Subscribe <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </form>
            <p class="subscribed-text">*Nous envoyons des bonnes affaires et les dernières nouvelles auto à nos utilisateurs abonnés chaque semaine.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">Copyright &copy; 2025 CarBNB louez des voitures.</p>
        </div>
      </div>
    </div>
  </div>
</footer>
