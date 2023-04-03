<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WEB 6</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="decor">
      <div class="form-left-decoration"></div>
      <div class="form-right-decoration"></div>
      <div class="circle"></div>
      <div class="form-inner">
        <h3 style="text-align: center;">Форма для отправки данных</h3>
      <div style="color: red; margin-bottom: 23px; text-align: left; font-size: 16px; <?php
      if($error){
        echo "display: none;";
      }
      ?>">
      <ul>
      <?php
        $pr="";
        if (isset($_COOKIE["nameErr"])) {
          $pr=$_COOKIE["nameErr"];
          echo "<li>$pr</li>";
        }
        if(isset($_COOKIE["emailErr"])){
          $pr=$_COOKIE["emailErr"];
          echo "<li>$pr</li>";
        }
        if(isset($_COOKIE["genderErr"])){
          $pr=$_COOKIE["genderErr"];
          echo "<li>$pr</li>";
        }
        if(isset($_COOKIE["kolErr"])){
          $pr=$_COOKIE["kolErr"];
          echo "<li>$pr</li>";
        }
        if(isset($_COOKIE["superpowersErr"])){
          $pr=$_COOKIE["superpowersErr"];
          echo "<li>$pr</li>";
        }
        if(isset($_COOKIE["biographyErr"])){
          $pr=$_COOKIE["biographyErr"];
          echo "<li>$pr</li>";
        }
      ?>
      </ul>
      </div>

      <div style="color: green; height: 25px; margin-bottom: 15px; text-align: center; font-size: 16px; <?php
      if(!isset($_COOKIE["mark"])){
        echo "display: none;";
      }
      ?>">
      <?php
      if(isset($_COOKIE["mark"])){
        if($_COOKIE["mark"]=="good"){
          echo "Ваши данные успешно отправлены.";
          setcookie("mark","",1000000);
        }else{
          echo "Ошибка отправки данных. Попробуйте ещё раз.";
          setcookie("mark","",1000000);
        }
      }
      ?>
      </div>
      <div style="color: red; height: 40px; margin-bottom: 20px; margin-left: 10px; text-align: left; font-size: 16px; <?php
      if(!isset($_COOKIE["login_new"])){
        echo "display: none;";
      }
      ?>">
        <?php
        if(isset($_COOKIE["login_new"])){
          $log = $_COOKIE["login_new"];
          $pass = $_COOKIE["password_new"];
          setcookie("login_new","",1000000);
          setcookie("password_new","",1000000);
          echo "Ваш логин: $log</br>Ваш пароль: $pass";
        }
        ?>
      </div>

        <input type="text" placeholder="Введите имя" name="name" style="
        <?php
          if (isset($_COOKIE["nameErr"])) {
            echo "background: #ffbaba";
          }
        ?>
        "
        value="<?php
          if(isset($_COOKIE["name"])){
            echo $_COOKIE["name"];
          }
          ?>"/>
        <input type="email" placeholder="Email" name="email" style="
        <?php
          if (isset($_COOKIE["emailErr"])){
            echo "background: #ffbaba";
          }
        ?>
        "
        value="<?php
          if(isset($_COOKIE["email"])){
            echo $_COOKIE["email"];
          }
          ?>"/>
        <a style="padding-left: 5px" style="white-space: nowrap"
          >Укажите год вашего рождения:
          <select
            id="year"
            name="year"
            size="1"
            style="display: inline"
          ></select
        ></a>
        <script>
          var objSel = document.getElementById("year");
          var c = 0;
          for (var i = 2023; i >= 1920; i--) {
            objSel.options[c] = new Option(i, i);
            c++;
          }
          document.getElementById('year').querySelectorAll('option')[2023-Number(<?php
            if(isset($_COOKIE["year"])){
              echo $_COOKIE["year"];
            }
            ?>)].selected = true;
        </script>
        <span style="<?php
        if(isset($_COOKIE["genderErr"])){
          echo "background: #ffbaba; border-radius: 20px;";
        } 
        ?>"><a style="margin-left: 5px">Укажите пол: </a
        ><a style="margin-left: 15px"
          >Мужской<input
            type="radio"
            name="pol"
            class="radio"
            value="Мужской" 
            <?php
              if(isset($_COOKIE["gender"])){
                if($_COOKIE["gender"]=="Мужской"){
                  echo "checked";
                }
              }?>/></a
        ><a style="margin-left: 10px"
          >Женский<input type="radio" name="pol" class="radio" value="Женский"
          <?php
            if(isset($_COOKIE["gender"])){
              if($_COOKIE["gender"]=="Женский"){
                echo "checked";
              }
            }
            ?>/></a></span>
        <br />
        <span style="<?php
        if(isset($_COOKIE["kolErr"])){
          echo "background: #ffbaba; border-radius: 20px;";
        }
        ?>"><a style="margin-left: 5px"
          >Кол-во конечностей:
          <a style="margin-left: 15px"
            >2 <input type="radio" name="kol" value="2"
            <?php
              if(isset($_COOKIE["kol"])){
                if($_COOKIE["kol"]=="2"){
                  echo "checked";
                }
              }
              ?>
          /></a>
          <a style="margin-left: 18px"
            >4 <input type="radio" name="kol" value="4"
            <?php
              if(isset($_COOKIE["kol"])){
                if($_COOKIE["kol"]=="4"){
                  echo "checked";
                }
              }
              ?>
          /></a>
          <a style="margin-left: 18px"
            >6 <input type="radio" name="kol" value="6"
            <?php
              if(isset($_COOKIE["kol"])){
                if($_COOKIE["kol"]=="6"){
                  echo "checked";
                }
              }
              ?>
             style="margin-bottom: 30px"
            />
          </a>
        </a>
          </span>
        <a style="margin-left: 6px">
          Укажите сверхспособности:
          <br />
          <select
            name="superpowers[]"
            style="
              display: inline;
              width: 180px;
              overflow-y: hidden;
              height: 60px;
              margin-top: 10px;
              margin-bottom: 30px;
              <?php
              if(isset($_COOKIE["superpowersErr"])){
                echo "background: #ffbaba;";
              }
              ?>
            "
            multiple="multiple"
          >
            <option value="бессмертие" <?php
              if(isset($_COOKIE["immortality"])){
                echo "selected";
              }
              ?>>бессмертие</option>
            <option value="прохождение сквозь стены" <?php
              if(isset($_COOKIE["passing_through_walls"])){
                echo "selected";
              }
              ?>>
              прохождение сквозь стены
            </option>
            <option value="левитация" <?php
              if(isset($_COOKIE["levitation"])){
                echo "selected";
              }
              ?>>левитация</option>
          </select>
        </a>
        <textarea placeholder="Биография" rows="3" name="biography" maxlength="255" style="<?php
        if(isset($_COOKIE["biographyErr"])){
          echo "background: #ffbaba; border-radius: 20px;";
        }
        ?>"><?php
          if(isset($_COOKIE["biography"])){
            echo $_COOKIE["biography"];
          }
          ?></textarea>
        <div
          style="
            width: 100%;
            display: flex;
            justify-content: center;
            height: 50px;
          "
        >
          <input type="submit" value="Отправить" style="margin: 15px"/>
        </div>
        <a id="ur" href="admin.php">Вернуться назад</a>
      </div>
    </form>
  </body>
</html>