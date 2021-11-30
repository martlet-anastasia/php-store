    <?php

        /**
         * @var array $errors
         */

        if(!count($errors)) {
           echo "<p>All files were successfully uploaded!</p>";
        } else {
            foreach($errors as $err) {
                echo "<p>" . $err . "</p>";
            }
        }





