Write_NetAtmo_Thermostat
========================

Cyril E      http://www.ituilerie.com
Ecriture de consigne au thermostat NetAtmo


Appel par l'url
http://xxxxxxxxx/thermostat_write.php?mode=off                     pour l'arret
http://xxxxxxxxx/thermostat_write.php?mode=program           pour passer en mode programme
http://xxxxxxxxx/thermostat_write.php?mode=away                pour passer en mode absent
http://xxxxxxxxx/thermostat_write.php?mode=hg                    pour passer en mode hors gel
http://xxxxxxxxx/thermostat_write.php?mode=max&length=120           pour passer en mode max pendant un certain temps (en minutes)  ici 120 minutes
http://xxxxxxxxx/thermostat_write.php?mode=manual&length=120&consigne=24           pour passer en mode manuel pendant un certain temps (en minutes)  ici 120 minutes a 24�c
