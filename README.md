University Project: website to manage a public library

Link: https://drive.google.com/open?id=0B2EFFw-dDHjjSGxHNEVmNEJ5b00

Internel version: alfa24

Bug: everything works

SQL:

CREATE TABLE Permesso(
	tipoUtente varchar(20) PRIMARY KEY,
	numeroLibri decimal(10) NOT NULL,
	tempoPrestito integer NOT NULL
);

CREATE TABLE Utente(
	mail varchar(30) PRIMARY KEY,
	numeroTessera serial,
	tipo varchar(10) REFERENCES Permesso(tipoUtente) ON UPDATE CASCADE NOT NULL,
	dataRegistrazione date NOT NULL,
	password varchar(10) NOT NULL,
	nome varchar(10) NOT NULL,
	cognome varchar(10) NOT NULL,
	numeroTelefono decimal(10,0) NOT NULL
);

CREATE TABLE Anagrafe(
	mailUtente varchar(30) PRIMARY KEY REFERENCES Utente(mail) ON UPDATE CASCADE NOT NULL,
	dataNascita date,
	cittaNascita varchar(10),
	sesso varchar(1),
	viaresidenza varchar(20),
	cittaResidenza varchar(10),
	provinciaResidenza varchar(10),
	statoResidenza varchar(10)
);

CREATE TABLE Dipendente(
	mail varchar(30) PRIMARY KEY,
	password varchar(10) NOT NULL,
	nome varchar(10) NOT NULL,
	cognome varchar(10) NOT NULL,
	numeroTelefono decimal(10,0) NOT NULL
);

CREATE TABLE CasaEditrice(
	nome varchar(20) PRIMARY KEY,
	citta varchar(20) NOT NULL
);

CREATE TABLE Autore(
	id serial PRIMARY KEY,
	nome varchar(10) NOT NULL,
	cognome varchar(10) NOT NULL,
	dataNascita date NOT NULL,
	cittaNascita varchar(10) NOT NULL,
	biografia varchar(1000) NOT NULL,
	UNIQUE(nome, cognome, dataNascita)
);

CREATE TABLE Libro(
	titolo varchar(50) NOT NULL,
	edizione decimal(20,0) NOT NULL,
	isbn varchar(20) NOT NULL,
	nomeCasaEditrice varchar(50) REFERENCES CasaEditrice(nome) ON UPDATE CASCADE NOT NULL,
	dataPubblicazione date NOT NULL,
	lingua varchar(20) NOT NULL,
	PRIMARY KEY (edizione, isbn)
);

CREATE TABLE Copia(
	nReg serial PRIMARY KEY,
	sezione char(20) NOT NULL,
	scaffale decimal(100,0) NOT NULL,
    	edizioneLibro decimal(20,0) NOT NULL,
    	isbnLibro varchar(20) NOT NULL,
	dataReg date NOT NULL,
    	FOREIGN KEY(edizioneLibro, isbnLibro) REFERENCES Libro(edizione, isbn),
    	UNIQUE (nReg, isbnLibro, edizioneLibro)
);

CREATE TABLE Prestito(
	mailUtente varchar(30) REFERENCES Utente(mail) ON UPDATE CASCADE NOT NULL,
	nRegCopia int REFERENCES Copia(nReg) NOT NULL,
	dataInizio date,
	dataFine date,
	voto decimal(5,0),
	commento varchar(1000),
	PRIMARY KEY(mailUtente, nRegCopia)
);

CREATE TABLE Scrive(
	isbnLibro varchar(20) NOT NULL,
	edizioneLibro decimal(20,0) NOT NULL,
	codAutore int REFERENCES Autore(id) ON UPDATE CASCADE NOT NULL,
	FOREIGN KEY(edizioneLibro, isbnLibro) REFERENCES Libro(edizione, isbn) ON UPDATE CASCADE,
	PRIMARY KEY(edizioneLibro, isbnLibro, codAutore)
);

INSERT INTO Permesso values ('docente', 10, 90);
INSERT INTO Permesso values ('studente', 5, 60);
INSERT INTO Permesso values ('altro', 3, 14);

INSERT INTO dipendente (mail, password, nome, cognome, numerotelefono) VALUES ('fnoto@unimi.it', 'fnoto', 'francesco', 'noto', '3334455666');