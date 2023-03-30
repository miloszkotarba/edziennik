<?php
if (!isset($_SESSION)) {
    session_start();
}

class alerts
{
    public static function SetError($message, $time = '6000')
    {
        $_SESSION['messages']['error'] = "
      const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: ".$time.",
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    
    Toast.fire({
      icon: 'error',
      title: '".$message."'
    })
   ";
    }

    public static function SetSuccess($message, $time = '6000')
    {
        $_SESSION['messages']['success'] = "
      const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: ".$time.",
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    
    Toast.fire({
      icon: 'success',
      title: '".$message."'
    })
   ";
    }

    public static function flashMessages()
    {
        if (isset($_SESSION['messages']['error'])) {
            echo "<script>" . $_SESSION['messages']['error'] . "</script>
";
            unset($_SESSION['messages']['error']);
        }

        if (isset($_SESSION['messages']['success'])) {
            echo "<script>" . $_SESSION['messages']['success'] . "</script>";
            unset($_SESSION['messages']['success']);
        }
    }
}

function redirect($location)
{
    header("Location: " . $location);
    exit();
}