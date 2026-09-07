# PlantBuddy


This PHP-based application is designed to track the complete growth lifecycle of a plant — from seed to flowering and harvest/end stage. It allows users to record and monitor key growth data using dates, making it suitable for any plant type, including vegetables, fruits, trees, and ornamental plants.

The system provides structured tracking of:

Growth stages (seed, germination, vegetative growth, flowering, maturation)

Water usage

Nutrient/fertilizer usage

Time-based development progress

Lifecycle history per plant

By using date-based tracking, the app offers a clear overview of each plant’s development, enabling consistent care, better planning, and improved cultivation insight over time.

This tool is designed to be simple, flexible, and universal, making it adaptable for any plant species that grows from seed.


INSTALLATION

After copying this directory to your webserver location with php support,

CREATE the subdirectories 'plants','nutrients' and 'water'.

MAKE SURE the directories 'plants','nutrients' and 'water' are writable by the webserver.

```bash
$sudo chown apache:apache plants nutrients water
```

Note: on Fedora you also need to configure SELINUX to allow writing to these directories:

```bash
$sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/html/plantbuddy/plants(/.*)?"

$sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/html/plantbuddy/nutrients(/.*)?"

$sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/html/plantbuddy/water(/.*)?"

$sudo restorecon -Rv /var/www/html/plantbuddy/plants

$sudo restorecon -Rv /var/www/html/plantbuddy/nutrients

$sudo restorecon -Rv /var/www/html/plantbuddy/water
```

After this the directories should be writable and the app should work.

Enjoy!

Made with love for mother nature. (Sia - Queen)

Note:  language:Hack is a programming language and I've no idea of where I'm using it in the code. If anyone knows, please let me know.

Note: You can do whole crops with the app just by changing the plant-name into grow-name. Just multiply the results by the number of plants.
