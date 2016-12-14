CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY,
nimi varchar(50) NOT NULL,
salasana varchar(50) NOT NULL
);

CREATE TABLE Askare(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
nimi varchar(50) NOT NULL,
paivamaara varchar(20),
kuvaus varchar(400),
tarkeys INTEGER DEFAULT 0
);

CREATE TABLE Kategoria(
id SERIAL PRIMARY KEY,
nimi varchar (30) NOT NULL
);

CREATE TABLE KateAska(
id SERIAL PRIMARY KEY,
askare_id INTEGER REFERENCES Askare(id),
kategoria_id INTEGER REFERENCES Kategoria(id)
);


