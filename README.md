# Drooble - Small Website
This is the small task prepared for <a href="https://drooble.com">Drooble</a>.

<h2>What's in the package?</h2>
<ul>
  <li>index.php - This is the first page of the website.</li>
  <li>database.php - This file contains the main information about your database setup:
    <ul>
      <li>$servername</li>
      <li>$db_name</li>
      <li>$db_user</li>
      <li>$db_pass</li>
    </ul>
  </li>
  <li>logged.php - This is the logged view of the user.</li>
  <li>assets - This is the folder with all assets used in the project:
    <ul>
      <li>ajax-handlers - This folder contains all AJAX handler scripts based on PHP.</li>
      <li>styles - This folder contains the styles used for the project, based on SCSS.</li>
      <li>db-controller.php - This file is used as an custom MySQL ORM for the project, all of its functions can be found in the code with small comments for each function.</li>
      <li>session-controller.php - This file is the $_SESSION wrapper built for the project.</li>
      <li>js-scripts.js - This file contains the JS scripts used for the project.</li>
    </ul>
  </li>
</ul>

<h2>How to setup?</h2>
<ol>
  <li>Download the project</li>
  <li>Setup MySQL database with username & password</li>
  <li>Change the variables in the <strong>database.php</strong> file</li>
  <li>That should be it</li>
</ol>
