<?php
use TopHat\Core;
use TopHat\User;

$alerts = Core::getAllAlerts();
$current_user = Core::getCurrentUser();

if (!empty($alerts)) { ?>

    <div class="alerts-container">

        <?php

        if (!empty($alerts[Core::ALERT_TYPE_ERROR])) {

            foreach ($alerts[Core::ALERT_TYPE_ERROR] as $alert) { ?>

                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?=$alert?>
                </div>
            <?php
            }
        }

        if (!empty($alerts[Core::ALERT_TYPE_EXCEPTION]) && $current_user && $current_user->type == User::TYPE_DEV) {

            foreach ($alerts[Core::ALERT_TYPE_EXCEPTION] as $alert) { ?>

                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?=$alert?>
                </div>
            <?php
            }
        }

        if (!empty($alerts[Core::ALERT_TYPE_WARNING])) {

            foreach ($alerts[Core::ALERT_TYPE_WARNING] as $alert) { ?>

                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?=$alert?>
                </div>
            <?php
            }
        }

        if (!empty($alerts[Core::ALERT_TYPE_SUCCESS])) {

            foreach ($alerts[Core::ALERT_TYPE_SUCCESS] as $alert) { ?>

                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?=$alert?>
                </div>
            <?php
            }
        }

        ?>

    </div>

<?php
}

