<div class="installer">
    <div class="installer_info">
        <div class="installer_title" style="color: white;">Установщик</div>
        <div>
            <ul>
                <?php 
                    for($i = 0; $i < count($nameSteps); $i++ ) {
                        echo '<li><div id="step_'.($i+1).'" class="installer_item">'.$nameSteps[$i].'</div></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="installer_space"></div>
</div>