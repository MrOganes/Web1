<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WEB 3</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <form action="index.php" method="POST" class="decor">
      <div class="form-left-decoration"></div>
      <div class="form-right-decoration"></div>
      <div class="circle"></div>
      <div class="form-inner">
        <h3 style="text-align: center;">Форма для отправки данных</h3>
      <div style="color: red; height: 25px; margin-bottom: 23px; text-align: center; font-size: 16px; <?php
      if(empty($error)){
        echo "display: none;";
      }
      ?>">
      <?php
      echo $error;
      ?>
      </div>

      <div style="color: green; height: 25px; margin-bottom: 23px; text-align: center; font-size: 16px; <?php
      if(empty($rez)){
        echo "display: none;";
      }
      ?>">
      <?php
      if($rez==1){
        echo "Ваши данные успешно отправлены.";
      }
      else{
        echo "Ошибка отпраки данных. Попробуйте ещё раз.";
      }
      ?>
      </div>

        <input type="text" placeholder="Введите имя" name="name" style="
        <?php
          if (!empty($nameErr)) {
            echo "background: #ffbaba";
          }
        ?>
        "
        value="<?php
          if(!empty($name)){
            echo "$name";
          }
          else{
            echo "";
          }
        ?>"/>
        
        <input type="email" placeholder="Email" name="email" style="
        <?php
          if (!empty($emailErr)) {
            echo "background: #ffbaba";
          }
        ?>
        "
        value="<?php
          if(!empty($email)){
            echo "$email";
          }
          else{
            echo "";
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
          if(!empty($year)){
            echo $year;
          }
          ?>)].selected = true;;
        </script>
        <span style="<?php
        if(!empty($genderErr)){
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
            if($gender=="Мужской"){
              echo "checked";
            }
            ?>/></a
        ><a style="margin-left: 10px"
          >Женский<input type="radio" name="pol" class="radio" value="Женский"
          <?php
            if($gender=="Женский"){
              echo "checked";
            }
          ?>/></a></span>
        <br />
        <span style="<?php
        if(!empty($kolErr)){
          echo "background: #ffbaba; border-radius: 20px;";
        }
        ?>"><a style="margin-left: 5px"
          >Кол-во конечностей:
          <a style="margin-left: 15px"
            >2 <input type="radio" name="kol" value="2"
            <?php
            if($kol=="2"){
              echo "checked";
            }
            ?>
          /></a>
          <a style="margin-left: 18px"
            >4 <input type="radio" name="kol" value="4"
            <?php
            if($kol=="4"){
              echo "checked";
            }
            ?>
          /></a>
          <a style="margin-left: 18px"
            >6 <input type="radio" name="kol" value="6"
            <?php
            if($kol=="6"){
              echo "checked";
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
              if(!empty($superpowersErr)){
                echo "background: #ffbaba;";
              }
              ?>
            "
            multiple="multiple"
          >
            <option value="бессмертие" <?php
            if(!empty($superpowers)){
              foreach($superpowers as $cout){
                if($cout =="бессмертие"){
                  echo "selected";
                }
              }
            }
            ?>>бессмертие</option>
            <option value="прохождение сквозь стены" <?php
            if(!empty($superpowers)){
              foreach($superpowers as $cout){
                if($cout =="прохождение сквозь стены"){
                  echo "selected";
                }
              }
            }
            ?>>
              прохождение сквозь стены
            </option>
            <option value="левитация" <?php
            if(!empty($superpowers)){
              foreach($superpowers as $cout){
                if($cout =="левитация"){
                  echo "selected";
                }
              }
            }
            ?>>левитация</option>
          </select>
        </a>
        <textarea placeholder="Биография" rows="3" name="biography" maxlength="255" style="<?php
        if(!empty($biographyErr)){
          echo "background: #ffbaba; border-radius: 20px;";
        }
        ?>"><?php
        if(empty($biographyErr)){
          echo $biography;
        }
        ?></textarea>
        <a style="display: flex; vertical-align: middle"
          ><input
            type="checkbox"
            style="width: 18px; height: 18px; margin-right: 10px"
            name="ok"
            value="Согласен"
          /><span style="margin-top: 3px"
            >C <span style="color: red">правилами</span> ознакомлен.</span
          ></a
        >
        <div
          style="
            width: 100%;
            display: flex;
            justify-content: center;
            height: 50px;
          "
        >
          <input type="submit" value="Отправить" style="margin: 15px" />
        </div>
      </div>
    </form>
  </body>
</html>