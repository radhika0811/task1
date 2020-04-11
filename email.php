<? php
        $firstname = $_REQUEST['name'];
        $lastname = $_REQUEST['name'];
        $dob = $_REQUEST['dob'];
        $email = $_REQUEST['mail'];
        $address = $_REQUEST['address'];
        $password = $_REQUEST['password'];

        if(empty($firstname) || empty($lastname) || empty($dob) || empty($email) || empty($address) || empty($password))
        {
            echo "Please enter values in fields";
        }
        else{
            mail("radhikaa245@gmail.com", "Details", ($address, $lastname, $dob, $password,), "From: $firstname<$email>" );
            echo"<script type = 'text/javascript'>alert('Form submission successful');
            window.history.log(-1);
            </script>";
        }
?>