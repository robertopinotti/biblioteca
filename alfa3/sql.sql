create table dipendente(
email varchar(50) PRIMARY KEY,
password varchar(50) NOT NULL,
nome varchar (40) NOT NULL,
cognome varchar(40) NOT NULL,
telefono varchar(10) NOT NULL
)

create table permesso (
tipo varchar (30) PRIMARY KEY,
durata_prestito integer NOT NULL,
max_libri integer NOT NULL
)

create table utente(
email varchar(50) PRIMARY KEY,
password varchar(50) NOT NULL,
nome varchar (40) NOT NULL,
cognome varchar(40) NOT NULL,
telefono varchar(15) NOT NULL,
n_tessera SERIAL UNIQUE,
data_registrazione date NOT NULL,
tipo varchar(30) NOT NULL REFERENCES permesso ON UPDATE CASCATE
)

create table casa_editrice(
sede varchar(50) NOT NULL,
denominazione varchar(50) NOT NULL,
PRIMARY KEY (sede,denominazione)
)

create table anagrafica(
email varchar(50) PRIMARY KEY REFERENCES utente,
sesso varchar (8) CONSTRAINT sesso_errato CHECK (sesso='Maschio' OR sesso='Femmina'),
data_nascita date,
luogo_nascita varchar(40),
stato varchar (40),
provincia varchar (40),
citta varchar (40)
)

create table libro(
titolo varchar(80) NOT NULL,
data_inserimento date NOT NULL,
lingua varchar(40),
PRIMARY KEY (titolo, data_inserimento)
)

create table copia(
n_registrazione serial PRIMARY KEY,
isbn varchar (30) NOT NULL,
edizione integer NOT NULL,
sezione varchar (10) NOT NULL,
scaffale integer NOT NULL,
titolo_libro varchar(80) NOT NULL,
data_inserimento_libro date NOT NULL,
FOREIGN KEY (titolo_libro, data_inserimento_libro) REFERENCES libro(titolo, data_inserimento),
sede_casa_editrice varchar(50) NOT NULL,
denominazione_casa_editrice varchar(50) NOT NULL,
FOREIGN KEY (sede_casa_editrice,denominazione_casa_editrice) REFERENCES casa_editrice(sede,denominazione),
anno_pubblicazione varchar(4) NOT NULL
)

create table prestito(
n_registrazione integer REFERENCES copia (n_registrazione),
email varchar(50) REFERENCES utente(email),
PRIMARY KEY(n_registrazione,email),
data_inizio date NOT NULL,
data_fine date,
voto integer CONSTRAINT voto_errato CHECK (voto>0 and voto<6),
commento varchar(500)
)

INSERT INTO permesso VALUES ('studente', 60, 5);
INSERT INTO permesso VALUES ('docente', 90, 10);
INSERT INTO permesso VALUES ('altro', 14, 3);

INSERT INTO utente (email, password, nome, cognome, telefono, data_registrazione, tipo) 
VALUES ('toto14.desi@gmail.com', 'pwd', 'antonio', 'desimone', '3494345654', '17/06/2017', 'studente');

INSERT INTO utente (email, password, nome, cognome, telefono, data_registrazione, tipo) 
VALUES ('lepo.luca96@gmail.com', 'pwd', 'luca', 'leporini', '3494345123', '18/06/2017', 'studente');

INSERT INTO utente (email, password, nome, cognome, telefono, data_registrazione, tipo)
VALUES ('mario.rossi@gmail.com', 'pwd', 'mario', 'rossi', '3494345789', '15/06/2015', 'docente');

INSERT INTO utente (email, password, nome, cognome, telefono, data_registrazione, tipo) 
VALUES ('paolo.verdi@gmail.com', 'pwd', 'paolo', 'verdi', '3494345333', '15/08/2016', 'altro');