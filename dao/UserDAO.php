<?php
require_once("Models/User.php");
require_once("Models/Message.php");

class UserDAOMysql implements UserDAOInterface
{

  private $conn;
  private $url;
  private $message;

  public function __construct(PDO $conn, $url)
  {
    $this->conn = $conn;
    $this->url = $url;
    $this->message = new Message($url);
  }

  public function buildUser($data)
  {

    $user = new User();

    $user->id = $data["id"];
    $user->name = $data["name"];
    $user->lastname = $data["lastname"];
    $user->email = $data["email"];
    $user->password = $data["password"];
    $user->image = $data["image"];
    $user->bio = $data["bio"];
    $user->token = $data["token"];

    return $user;
  }

  public function create(User $user, $authUser = false)
  {

    $stmt = $this->conn->prepare("INSERT INTO users(
          name, lastname, email, password, token
        ) VALUES (
          :name, :lastname, :email, :password, :token
        )");

    $stmt->bindParam(":name", $user->name);
    $stmt->bindParam(":lastname", $user->lastname);
    $stmt->bindParam(":email", $user->email);
    $stmt->bindParam(":password", $user->password);
    $stmt->bindParam(":token", $user->token);

    $stmt->execute();

    // Autenticar usuário, caso auth seja true
    if ($authUser) {
      $this->setTokenSession($user->token);
    }
  }

  public function update(User $user, $redirect = true)
  {
    $stmt = $this->conn->prepare("UPDATE USERS SET
    NAME = :NAME,
    LASTNAME = :LASTNAME,
    EMAIL = :EMAIL,
    IMAGE = :IMAGE,
    BIO = :BIO,
    TOKEN = :TOKEN
    WHERE ID = :ID
    ");
    $stmt->bindParam(":NAME", $user->name);
    $stmt->bindParam(":LASTNAME", $user->lastname);
    $stmt->bindParam(":EMAIL", $user->email);
    $stmt->bindParam(":IMAGE", $user->image);
    $stmt->bindParam(":BIO", $user->bio);
    $stmt->bindParam(":TOKEN", $user->token);
    $stmt->bindParam(":ID", $user->id);

    $stmt->execute();

    if ($redirect) {
      $this->message->SetMessage("Dados atualizados com sucesso!", "alert-success", "editProfile.php");
    }
  }

  public function verifyToken($protected = false)
  {
    if (!empty($_SESSION['token'])) {
      $token = $_SESSION['token'];
      $user = $this->findByToken($token);
      if ($user) {
        return $user;
      } else if ($protected) {
        $this->message->SetMessage("Faça a autenticação para obter acesso.", "alert-danger", "index.php");
      };
    } else if ($protected) {
      $this->message->SetMessage("Faça a autenticação para obter acesso.", "alert-danger", "index.php");
    };
  }
  

  public function setTokenSession($token, $redirect = true)
  {

    $_SESSION["token"] = $token;

    if ($redirect) {

      $this->message->setMessage("Seja bem-vindo!", "alert-success", "editProfile.php");
    }
  }

  public function authenticateUser($email, $password)
  {
    $user = $this->findByEmail($email);
    if ($user) {
      if (password_verify($password, $user->password)) {
        $token = $user->generateToken();
        $this->setTokenSession($token, false);
        $user->token = $token;
        $this->update($user, false);
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function findByEmail($email)
  {

    if ($email != "") {

      $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

      $stmt->bindParam(":email", $email);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function findById($id)
  {
    if ($id != "") {

      $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

      $stmt->bindParam(":id", $id);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function findByToken($token)
  {
    if ($token != "") {

      $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

      $stmt->bindParam(":token", $token);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function destroyToken()
  {
    $_SESSION['token'] = '';
    $this->message->SetMessage("Logout feito com sucesso!", "alert-success", "index.php");
  }

  public function changePassword(User $user)
  {

    $stmt = $this->conn->prepare("UPDATE USERS SET
    PASSWORD = :PASSWORD
    WHERE ID = :ID
    ");

    $stmt->bindParam(":PASSWORD", $user->password);
    $stmt->bindParam(":ID", $user->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $this->message->setMessage("Senha alterada com sucesso!", "alert-success", "editProfile.php");
    } else {
      $this->message->setMessage("Não foi possivel realizar a operação", "alert-danger", "editProfile.php");
    }
  }
}
