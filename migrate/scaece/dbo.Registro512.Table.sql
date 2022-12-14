/****** Object:  Table [dbo].[Registro512]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro512](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](3) NULL,
	[PatenteAduanalOrig] [varchar](4) NULL,
	[PedimentoOriginal] [varchar](7) NULL,
	[SeccionAduaneraDespOrig] [varchar](50) NULL,
	[DocumentoOriginal] [varchar](50) NULL,
	[FechaOperacionOrig] [date] NULL,
	[FraccionOriginal] [varchar](8) NULL,
	[UnidadMedida] [varchar](2) NULL,
	[MercanciaDescargada] [decimal](18, 3) NULL,
	[TipoPedimento] [varchar](50) NULL,
	[FechaPagoReal] [datetime] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
