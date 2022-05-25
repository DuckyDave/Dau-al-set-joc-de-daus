# Laravel API REST

Objectiu: crear una API completa amb control d'accés configurat amb tokens.

## Nivell 1

- El joc de daus es juga amb dos daus. En cas que el resultat dels dos daus sigui 7, la partida és guanyada, sinó és perduda. Per poder jugar al joc prèviament has d'estar registrat com a usuari a l'aplicació amb un email únic i un nickname que no s'ha de repetir entre usuaris o si es prefereix, pot no afegir cap nom i es dirà “Anònim” per defecte. Hi pot haver més d'un jugador anònim. En crear un nou usuari, se us assigna un identificador únic i una data de registre.

- Cada jugador pot veure un llistat de tots els tirades que ha realitzat, amb el valor de cada dau i si s'ha guanyat o no la partida. A més, podeu saber el seu percentatge d'èxit per totes les tirades que ha realitzat.

- No es pot eliminar una tirada en concret, però sí que es pot eliminar tot el llistat de tirades per un jugador.

- El programari ha de permetre a l'administrador de l'aplicació visualitzar tots els jugadors que hi ha al sistema, veure el percentatge d'èxit de cada jugador i el percentatge d'èxit mitjà de tots els jugadors al sistema.

- El programari ha de respectar els principals patrons de disseny.



### Afegix seguretat

- Inclou autenticació per passport en tots els accessos a les URL del microservei.
Defineix sistema de rols i bloqueja l'accés a les diferents rutes segons el seu nivell de privilegis.


### Testing

- Crea els tests unitaris d'integració en l'aplicació. Treballaràs aplicant TDD a l'aplicació per provar cadascuna de les rutes.
 

### NOTES

- Has de tindre en compte els següents detalls de construcció:

### URL’s:


- POST /players : crea un jugador
- PUT /players/{id} : modifica el nom del jugador
- POST /players/{id}/games/ : un jugador específic realitza una tirada dels daus.
- DELETE /players/{id}/games: elimina les tirades del jugador
- GET /players: retorna el llistat de tots els jugadors del sistema amb el seu percentatge mig d’èxits 
- GET /players/{id}/games: retorna el llistat de jugades per un jugador.
- GET /players/ranking: retorna el ranking mig de tots els jugadors del sistema. És a dir, el percentatge mig d’èxits.
- GET /players/ranking/loser: retorna el jugador amb pitjor percentatge d’èxit
- GET /players/ranking/winner: retorna el jugador amb pitjor percentatge d’èxit.

## Nivell 2

- Crea una aplicació frontal amb AJAX per consumir les dades de les diferents rutes. Si vols pots fer-la mitjançant un framework: Angular, Vue, React…
- Soluciona el CORS, en cas d'aparèixer en establir la comunicació entre front i back.

## Nivell 3
- Desplega el teu projecte en producció.