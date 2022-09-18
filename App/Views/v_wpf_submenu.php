<style>
    .box-ct-toolbox {
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #d9d9d9;
        box-shadow: 0px 0px 5px 0px #f6f6f6; 
        margin: 15px;
        background: white;
    } 
</style>

<div class="box-ct-toolbox">
    <h1>Welcome!</h1>
    <div><b>Name: <?= $data_users['name']; ?></b></div>
    <div>Message: <?= $data_users['message']; ?></div>
</div>