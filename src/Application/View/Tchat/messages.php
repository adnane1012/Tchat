<div class="row message-previous">
    <div class="col-sm-12 previous">
    </div>
</div>
<?php foreach ($messages as $message) : ?>
    <?php if ($message->getSender() == $curentUserId) : ?>
        <div class="row message-body">
            <div class="col-sm-12 message-main-receiver">
                <div class="receiver">
                    <div class="message-text">
                        <?php echo $message->getMessage(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row message-body">
            <div class="col-sm-12 message-main-sender">
                <div class="sender">
                    <div class="message-text">
                        <?php echo $message->getMessage(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>