<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="page-header">Welcome to <?=APP_NAME?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-1 centered">
        <h2 class="centered">Word</h2>
        <p>Our random word is "<?= $word ?>"</p>
    </div>
    <div class="col-md-4 col-md-offset-2 centered">
        <h2>Rhymes</h2>
        <p>Our rhymes for <?= $word ?> are:
            <ul>
                <?php foreach ($rhymes as $rhyme)
                    echo '<li>' . $rhyme . '</li>';
                ?>
            </ul>
        </p>

    </div>
</div>
