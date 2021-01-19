CREATE TABLE [dbo].[tx_user](
	[XX_C_USR] [varchar](15) NOT NULL,
	[XX_PASSWD] [varchar](128) NOT NULL,
	[CX_C_DITTA] [int] NULL,
	[TX_C_CLIENT] [varchar](64) NOT NULL,
	[TG_DTINITV] [int] NOT NULL,
	[TG_DTFINEV] [int] NOT NULL,
	[XX_DTCARICA] [int] NOT NULL,
	[XX_DTVARIAZ] [int] NOT NULL,
	[DB_C_USR] [varchar](32) NOT NULL,
	[CX_C_NOME] [int] NULL,
	[CX_C_TP_M005] [varchar](4) NOT NULL,
	[AV_C_LANG] [varchar](4) NOT NULL,
	[TX_C_RDPSES] [varchar](16) NOT NULL,
	[TX_F_IPDYN] [smallint] NOT NULL,
	[XX_PWD_MAIL] [varchar](128) NOT NULL,
	[TX_T_USER] [varchar](1) NOT NULL,
	[XX_USR_MAIL] [varchar](128) NOT NULL,
	[XX_F_MAILIN] [smallint] NOT NULL,
 CONSTRAINT [tx_user_pk0] PRIMARY KEY NONCLUSTERED 
(
	[XX_C_USR] ASC
);

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df0]  DEFAULT (null) FOR [CX_C_DITTA]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df1]  DEFAULT (0) FOR [TG_DTINITV]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df2]  DEFAULT (0) FOR [TG_DTFINEV]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df97]  DEFAULT (730486) FOR [XX_DTCARICA]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df98]  DEFAULT (0) FOR [XX_DTVARIAZ]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df99]  DEFAULT (user_name()) FOR [DB_C_USR]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df3]  DEFAULT (null) FOR [CX_C_NOME]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df4]  DEFAULT ('M005') FOR [CX_C_TP_M005]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df5]  DEFAULT ((0)) FOR [TX_F_IPDYN]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df6]  DEFAULT ('') FOR [XX_PWD_MAIL]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df7]  DEFAULT ('') FOR [TX_T_USER]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df8]  DEFAULT ('') FOR [XX_USR_MAIL]
;

ALTER TABLE [dbo].[tx_user] ADD  CONSTRAINT [tx_user_df9]  DEFAULT ((0)) FOR [XX_F_MAILIN]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_fk0] FOREIGN KEY([XX_C_USR], [CX_C_DITTA])
REFERENCES [dbo].[tx_cfgus] ([XX_C_USR], [CX_C_DITTA])
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_fk0]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_fk1] FOREIGN KEY([CX_C_NOME])
REFERENCES [dbo].[tn_nomi] ([CX_C_NOME])
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_fk1]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_fk2] FOREIGN KEY([CX_C_TP_M005], [AV_C_LANG])
REFERENCES [dbo].[tg_tab] ([CX_C_TIPO], [CX_C_CODICE])
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_fk2]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct0] CHECK  ((len(rtrim([XX_C_USR])) > 0 and [XX_C_USR] = upper([XX_C_USR])))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct0]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct1] CHECK  (([TG_DTINITV] >= 0))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct1]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct2] CHECK  (([TG_DTFINEV] >= 0))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct2]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct3] CHECK  (([CX_C_TP_M005]='M005'))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct3]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct4] CHECK  (([TX_F_IPDYN]>=(0) AND [TX_F_IPDYN]<=(1)))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct4]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct5] CHECK  (([TX_T_USER]=''))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct5]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct6] CHECK  (([XX_F_MAILIN]=(5) OR [XX_F_MAILIN]=(3) OR [XX_F_MAILIN]=(2) OR [XX_F_MAILIN]=(1) OR [XX_F_MAILIN]=(0)))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct6]
;

ALTER TABLE [dbo].[tx_user]  WITH CHECK ADD  CONSTRAINT [tx_user_ct99] CHECK  (([XX_DTCARICA] > 0))
;

ALTER TABLE [dbo].[tx_user] CHECK CONSTRAINT [tx_user_ct99]
;


