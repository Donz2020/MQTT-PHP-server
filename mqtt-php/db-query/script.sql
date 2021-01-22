USE [banche]
;
/****** Object:  Table [dbo].[tx_abi]    Script Date: 01/22/2021 12:33:02 ******/
SET ANSI_NULLS ON
;
SET QUOTED_IDENTIFIER ON
;
SET ANSI_PADDING ON
;
CREATE TABLE [dbo].[tx_abi](
	[CN_C_ABI] [int] NOT NULL,
	[CN_C_CAB] [int] NOT NULL,
	[CN_D_RAGSOC] [varchar](40) NOT NULL,
	[CN_D_NOME] [varchar](20) NULL,
	[CN_C_COMUNE] [varchar](4) NOT NULL,
	[CN_D_VIA] [varchar](120) NOT NULL,
	[XX_DTCARICA] [int] NOT NULL,
	[XX_DTVARIAZ] [int] NOT NULL,
	[DB_C_USR] [varchar](32) NOT NULL,
	[TN_D_LOCALIT] [varchar](120) NOT NULL,
	[TX_F_INATTIV] [smallint] NOT NULL,
	[TX_N_ROWID] [int] IDENTITY(1,1) NOT NULL,
 CONSTRAINT [tx_abi_pk0] PRIMARY KEY CLUSTERED 
(
	[CN_C_ABI] ASC,
	[CN_C_CAB] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
;
SET ANSI_PADDING OFF
;
/****** Object:  Table [dbo].[ABICAB]    Script Date: 01/22/2021 12:33:02 ******/
SET ANSI_NULLS ON
;
SET QUOTED_IDENTIFIER ON
;
SET ANSI_PADDING ON
;
CREATE TABLE [dbo].[ABICAB](
	[AbcAbi] [int] NOT NULL,
	[AbcCab] [int] NOT NULL,
	[AbcBanc] [varchar](50) NULL,
	[AbcFiliale] [varchar](50) NULL,
	[AbcIndir] [varchar](70) NULL,
	[AbcCap] [varchar](10) NULL,
	[AbcLocalita] [varchar](50) NULL,
	[AbcComune] [varchar](50) NULL,
	[AbcProv] [varchar](2) NULL,
	[AbcAbichk] [smallint] NOT NULL,
	[AbcCabchk] [decimal](27, 9) NULL,
	[AbcStato] [varchar](3) NULL,
	[AbcSwift] [varchar](14) NULL,
	[AbcCabhq] [int] NOT NULL,
	[AbcTelef] [varchar](18) NULL,
	[AbcFax] [varchar](18) NULL,
	[AbcIndpost] [varchar](35) NULL,
	[AbcNote] [varchar](255) NULL,
 CONSTRAINT [ABICAB_PrimaryKey] PRIMARY KEY CLUSTERED 
(
	[AbcAbi] ASC,
	[AbcCab] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
;
SET ANSI_PADDING OFF
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Cod. abi' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcAbi'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Cod. cab' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcCab'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Denom. banca' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcBanc'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Ident. della filiale' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcFiliale'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Indirizzo' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcIndir'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Cap' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcCap'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Citta'', località' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcLocalita'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Comune' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcComune'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'provincia' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcProv'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Flag filiale soppressa (0=operativa, 1=soppressa)' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcAbichk'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Check digit del codice cab' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcCabchk'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Stato sportello' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcStato'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'codice BIC/SWIFT' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcSwift'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'cod. cab sede centrale (Headquarter)' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcCabhq'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'telefono' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcTelef'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Fax' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcFax'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Indirizzo postale' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcIndpost'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Note' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB', @level2type=N'COLUMN',@level2name=N'AbcNote'
;
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'Codici CAB (banche)' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'ABICAB'
;
/****** Object:  Default [DF_ABICAB_AbcAbi]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[ABICAB] ADD  CONSTRAINT [DF_ABICAB_AbcAbi]  DEFAULT ((0)) FOR [AbcAbi]
;
/****** Object:  Default [DF_ABICAB_AbcCab]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[ABICAB] ADD  CONSTRAINT [DF_ABICAB_AbcCab]  DEFAULT ((0)) FOR [AbcCab]
;
/****** Object:  Default [DF_ABICAB_AbcAbichk]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[ABICAB] ADD  CONSTRAINT [DF_ABICAB_AbcAbichk]  DEFAULT ((0)) FOR [AbcAbichk]
;
/****** Object:  Default [DF_ABICAB_AbcCabhq]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[ABICAB] ADD  CONSTRAINT [DF_ABICAB_AbcCabhq]  DEFAULT ((0)) FOR [AbcCabhq]
;
/****** Object:  Default [tx_abi_df97]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi] ADD  CONSTRAINT [tx_abi_df97]  DEFAULT ((730486)) FOR [XX_DTCARICA]
;
/****** Object:  Default [tx_abi_df98]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi] ADD  CONSTRAINT [tx_abi_df98]  DEFAULT ((0)) FOR [XX_DTVARIAZ]
;
/****** Object:  Default [tx_abi_df99]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi] ADD  CONSTRAINT [tx_abi_df99]  DEFAULT (user_name()) FOR [DB_C_USR]
;
/****** Object:  Default [tx_abi_df0]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi] ADD  CONSTRAINT [tx_abi_df0]  DEFAULT ('') FOR [TN_D_LOCALIT]
;
/****** Object:  Default [tx_abi_df1]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi] ADD  CONSTRAINT [tx_abi_df1]  DEFAULT ((0)) FOR [TX_F_INATTIV]
;
/****** Object:  Check [tx_abi_ct0]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi]  WITH CHECK ADD  CONSTRAINT [tx_abi_ct0] CHECK  (([CN_C_ABI]>=(0) AND [CN_C_ABI]<=(99999)))
;
ALTER TABLE [dbo].[tx_abi] CHECK CONSTRAINT [tx_abi_ct0]
;
/****** Object:  Check [tx_abi_ct1]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi]  WITH CHECK ADD  CONSTRAINT [tx_abi_ct1] CHECK  (([CN_C_CAB]>=(1) AND [CN_C_CAB]<=(99999)))
;
ALTER TABLE [dbo].[tx_abi] CHECK CONSTRAINT [tx_abi_ct1]
;
/****** Object:  Check [tx_abi_ct2]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi]  WITH CHECK ADD  CONSTRAINT [tx_abi_ct2] CHECK  ((len(rtrim([CN_D_VIA]))>(0)))
;
ALTER TABLE [dbo].[tx_abi] CHECK CONSTRAINT [tx_abi_ct2]
;
/****** Object:  Check [tx_abi_ct3]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi]  WITH CHECK ADD  CONSTRAINT [tx_abi_ct3] CHECK  (([TX_F_INATTIV]>=(0) AND [TX_F_INATTIV]<=(1)))
;
ALTER TABLE [dbo].[tx_abi] CHECK CONSTRAINT [tx_abi_ct3]
;
/****** Object:  Check [tx_abi_ct99]    Script Date: 01/22/2021 12:33:02 ******/
ALTER TABLE [dbo].[tx_abi]  WITH CHECK ADD  CONSTRAINT [tx_abi_ct99] CHECK  (([XX_DTCARICA]>(0)))
;
ALTER TABLE [dbo].[tx_abi] CHECK CONSTRAINT [tx_abi_ct99]
;
