<?php


/* @var $this yii\web\View */
/* @return mixed
 * @var $dataProvider yii\data\ActiveDataProvider
 */
/* @var $pages yii\data\Pagination */

$this->title = 'Family Tree';
?>
<div id="log"></div>
<div class="tree" id="tree"></div>
<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <p>Some text in the Modal..</p>
    </div>
</div>
<div class="row">
    <div class="person-body-1">
        test
    </div>
</div>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
