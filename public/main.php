<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 14:06
 */

include_once "../files/session.php";

//check if user is logged in
if(!isset($_SESSION["username"])){
    header("location: ../index.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>cefl car checker</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<header>
    <nav>
        <a class="nav_empty" href="#top">top</a>
        <a class="nav_logo" href="">cefl</a>
        <a class="nav_logout" href="../files/logout.php">logout</a>
    </nav>

    <div class="outer_wrapper">
        <div id="searchForm_zone" class="inner_wrapper">
            <form action="" method="post" autocomplete="off" id="searchForm">
                <select name="searchForm_searchOn" id="searchForm_searchOn">
                    <option value="searchForm_selectLicenseplate">Plaque d'immatriculation</option>
                    <option value="searchForm_selectDriver">Chauffeur</option>
                    <option value="searchForm_selectFirm">Entreprise</option>
                    <option value="searchForm_selectDomicile">Domicile</option>
                </select>
                <input type="text" placeholder="Jetez les dés..." name="searchForm_inputZoekwaarde"
                       id="searchForm_inputZoekwaarde">
                <input type="submit" value="Recherche DB" name="searchForm_submitCheck" id="searchForm_submitCheck">
            </form>
        </div>
    </div>
</header>

<div class="container">
    <div id="searchResult_colorIndicator" class="outer_wrapper">
        <div id="searchResult_zone" class="inner_wrapper">
            <div id="searchResult_aroundTable">
                <table id="searchResult_table">
                    <thead>
                    <tr>
                        <th>Plaque</th>
                        <th>Marque</th>
                        <th>Chauffeur</th>
                        <th>Entreprise</th>
                    </tr>
                    </thead>
                </table>
            </div>

            <form action="" method="post" autocomplete="off" id="searchResultForm">
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputNummerplaat">Plaque</label>
                    <input placeholder="... ..." type="text" name="searchResultForm_inputNummerplaat" id="searchResultForm_inputNummerplaat" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputMerk">Marque</label>
                    <input placeholder="... ..." type="text" name="searchResultForm_inputMerk" id="searchResultForm_inputMerk" class="searchResultForm_inputDisabled" disabled="disabled">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputOwner">Owner</label>
                    <input placeholder="... ..." type="text" name="searchResultForm_inputOwner" id="searchResultForm_inputOwner" class="searchResultForm_inputDisabled" disabled="disabled">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputDriver">Chauffeur</label>
                    <input type="text" name="searchResultForm_inputDriver" id="searchResultForm_inputDriver" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputFirma">Entreprise</label>
                    <input type="text" name="searchResultForm_inputFirma" id="searchResultForm_inputFirma" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputAdres">Adresse</label>
                    <input type="text" name="searchResultForm_inputAdres" id="searchResultForm_inputAdres" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputTel">N° de tél</label>
                    <input type="text" name="searchResultForm_inputTel" id="searchResultForm_inputTel" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputGsm">N° de gsm</label>
                    <input type="text" name="searchResultForm_inputGsm" id="searchResultForm_inputGsm" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_selectNplDeleted">Plaque archivé</label>
                    <select name="searchResultForm_selectNplDeleted" id="searchResultForm_selectNplDeleted" class="searchResultForm_inputDisabled" disabled="disabled" >
                        <option value="0">Non</option>
                        <option value="1">Oui</option>
                    </select>
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputTitDeleted">Titulaire archivé</label>
                    <input type="text" name="searchResultForm_inputTitDeleted" id="searchResultForm_inputTitDeleted" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputTitGrpOmschrijving">Description GRP</label>
                    <input type="text" name="searchResultForm_inputTitGrpOmschrijving" id="searchResultForm_inputTitGrpOmschrijving" readonly="readonly">
                </div>
                <div class="searchResultForm_divGroup">
                    <label for="searchResultForm_inputTitGrpBareelopen">Baril ouvert</label>
                    <input type="text" name="searchResultForm_inputTitGrpBareelopen" id="searchResultForm_inputTitGrpBareelopen" readonly="readonly">
                </div>

                <input type="button" value="Edit" name="searchResultForm_buttonEdit" id="searchResultForm_buttonEdit">
                <input type="submit" value="Update" name="searchResultForm_submitUpdate" id="searchResultForm_submitUpdate">
                <input type="button" value="Nouveau" name="searchResultForm_buttonNew" id="searchResultForm_buttonNew">
                <input type="submit" value="Insert" name="searchResultForm_submitNew" id="searchResultForm_submitNew">
                <button id="searchResultForm_buttonBack">Retour à la liste</button>

                <p id="searchResultForm_message"></p>
            </form>

            <div id="searchResult_geenResultaat">
                <p>on a rien trouvé ...</p>
            </div>

            <div id="searchResult_nietsIngegeven">
                <p>pas d'info, pas de résultat ...</p>
            </div>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>