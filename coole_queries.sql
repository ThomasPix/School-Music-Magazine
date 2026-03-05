# Selecteer wat songs van de database (30 stuks)
SELECT * FROM Songs ORDER BY RAND() LIMIT 30;

# Check voor de username blijkbaar
SELECT * FROM Users WHERE Username = :username AND deleted = 'N';

# Maak account
INSERT INTO Users (Username, Password, IsArtist) VALUES (:username, :password, :isArtist);

# Update account
UPDATE Users SET Username = :username, Password = :password;
UPDATE Songs SET Username = :username WHERE Username = :oldusername;

