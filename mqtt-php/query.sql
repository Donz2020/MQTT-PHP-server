-- DROP TABLE tx_mqttlog
-- ;
CREATE TABLE tx_mqttlog (
  TX_L_SERIAL int identity not null,
  TX_DATA int not null,
  TX_ORA int not null,
  TX_C_SERVER varchar(64) not null,
  TOPIC VARCHAR(255) not null,
  REPARTO VARCHAR(4),
  UTENTE VARCHAR(15),
  MESSAGGIO VARCHAR(8000) not null,
  F_LETTO SMALLINT not null,
  F_ANNULLATO SMALLINT not null
 )
;

CREATE UNIQUE CLUSTERED INDEX tx_mqttlog_ix0  on tx_mqttlog (TX_L_SERIAL)
;



INSERT INTO tx_mqttlog (TX_DATA,TX_ORA,TX_C_SERVER,TOPIC,MESSAGGIO,F_LETTO,F_ANNULLATO)
VALUES ('12122020','150322','192.168.120.113','amm','nuovabolla','0','0');



CREATE TRIGGER checkTM ON tx_mqttlog
AFTER INSERT
AS PRINT ('You made one DML operation');

------------------------------------

CREATE TABLE customer (
  ID int identity not null,
  LASTNAME varchar(64) not null,
  FIRSTNAME VARCHAR(64) not null,
  ADDRESS VARCHAR(15) NOT NULL,
  CITY VARCHAR(15)NOT NULL,
  TYPE VARCHAR(15) not null,
  DATA int not null,
  ORA int not null
 )
;

drop table customer;

INSERT INTO customer (LASTNAME,FIRSTNAME,ADDRESS,CITY,TYPE)
VALUES ('INSURANCE INC','','eee','Chicago','C');


CREATE TRIGGER trig_customers
ON customer
AFTER INSERT, UPDATE, DELETE
AS PRINT ('You made one DML operation');


INSERT INTO customer (LASTNAME,FIRSTNAME,ADDRESS,CITY,TYPE)
VALUES ('Alessandro', 'Adams', 'fff', 'San Francisco', 'I');


create table Logs  
(  
Activity varchar(20),  
Activity_date datetime  
)




CREATE TRIGGER trigger_ex ON customer  
AFTER INSERT  
AS  
Insert into Logs values('Data is inserted',getdate())

select * from customer 
select * from Logs 


CREATE TRIGGER trigger_ex2 ON customer
Instead of INSERT  
AS  
Insert into Logs values('Data is inserted',getdate());


-- cambiare type dalla tabella customer attraverso un trigger
--


CREATE TRIGGER change on customer
FOR INSERT,UPDATE,DELETE
AS
INSERT INTO Logs(Activity)  VALUES('I');


INSERT INTO customer (LASTNAME,FIRSTNAME,ADDRESS,CITY,TYPE)
VALUES ('ciao', 'Adams', 'fff', 'San Francisco', 'B');


CREATE TRIGGER change on customer
FOR INSERT,UPDATE,DELETE
AS
UPDATE customer
SET TYPE = 'I'
WHERE LASTNAME = 'ciao';


INSERT INTO customer (LASTNAME,FIRSTNAME,ADDRESS,CITY,TYPE)  
VALUES('', '', '', '', 'D');


UPDATE  customer
SET TYPE = 'B'
Where TYPE = 'I';



CREATE TRIGGER change on customer
INSTEAD OF INSERT,UPDATE,DELETE
AS
INSERT INTO customer(TYPE) VALUES ('G');



---funziona

DROP TRIGGER change;


CREATE TRIGGER change on customer
AFTER INSERT,UPDATE,DELETE
AS
UPDATE customer
SET TYPE = 'E'
WHERE ID = (SELECT MAX(ID) FROM customer);




INSERT INTO customer (LASTNAME,FIRSTNAME,ADDRESS,CITY,TYPE,DATA,ORA)
VALUES ('ciao', 'Adams', 'fff', 'San Francisco', 'G','','');



CREATE TRIGGER change on customer
INSTEAD OF INSERT,UPDATE,DELETE
AS
UPDATE customer
SET TYPE = 'E'
WHERE ID = (SELECT MAX(ID) FROM customer);










CREATE TRIGGER insertDateTime on customer
FOR 
INSERT,UPDATE
AS
update customer
set DATA = cast(getdate() as int)+693960
WHERE ID = (SELECT MAX(ID) FROM customer);




CREATE TRIGGER insertTime on customer
FOR 
INSERT,UPDATE
AS
update customer
set ORA = cast(getdate() as int)+693960
WHERE ID = (SELECT MAX(ID) FROM customer);




//sbagliato
select cast(getdate() as int)+693960;

select cast(getdate() as float);



//ora in intero


SELECT CONVERT(INT, GETDATE());



SELECT cast(SYSDATETIME()as int) ;

select cast(GETDATE()as int);