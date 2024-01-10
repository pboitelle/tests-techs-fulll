# Requirements
To run this project you will need a computer with PHP and composer installed.

# Install
To install the project, you just have to run `composer install` to get all the dependencies

# Running the tests
After installing the dependencies you can run the tests with this command `vendor/behat/behat/bin/behat`.
The result should look like this :
![behat.png](behat.png)

# Running the cli commands
After installing the dependencies you can run cli commands with this command 
- `php app.php fleet:create [fleetId]`
- `php app.php fleet:register-vehicle <fleetId> <vehicleId>`
- `php app.php fleet:localize-vehicle <fleetId> <vehicleId> <lat> <lng> <alt>`