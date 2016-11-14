-- Kayttaja-taulun testidata
INSERT INTO Kayttaja(nimi, salasana) VALUES ('Koistinen', 'kukka123');
INSERT INTO Kayttaja(nimi, salasana) VALUES ('Kekkonen', 'kukka123');
INSERT INTO Kayttaja(nimi, salasana) VALUES ('Teppo', 'tulppu');
-- Askare-taulun testidata
INSERT INTO Askare(nimi, paivamaara, kuvaus) VALUES ('Kukkien kastelu', '15.12', 'Kukat kasteltava tai ne kuolevat');
INSERT INTO Askare(nimi, paivamaara, kuvaus) VALUES ('Parran ajaminen', '1.12', 'Parta ajettava tai tulee huutia');

INSERT INTO Suoritetutaskareet(nimi) VALUES ('Ruoan teko');