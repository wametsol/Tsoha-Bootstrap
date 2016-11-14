CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY,
nimi varchar(50) NOT NULL,
salasana varchar(50) NOT NULL,
admin boolean DEFAULT FALSE
);

CREATE TABLE Askare(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
nimi varchar(50) NOT NULL,
paivamaara varchar(20),
kuvaus varchar(400)
);

CREATE TABLE Tarkeysaste(
askare_id INTEGER REFERENCES Askare(id),
tarkeys INTEGER
);

CREATE TABLE Suoritetutaskareet(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
askare_id INTEGER REFERENCES Askare(id),
nimi varchar(50) NOT NULL
);