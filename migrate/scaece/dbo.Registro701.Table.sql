/****** Object:  Table [dbo].[Registro701]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro701](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](4) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](3) NULL,
	[ClaveDocumento] [varchar](2) NULL,
	[FechaPago] [date] NULL,
	[PedimentoAnterior] [varchar](50) NULL,
	[PatenteAnterior] [varchar](50) NULL,
	[SeccionAduaneraAnterior] [varchar](50) NULL,
	[DocumentoAnterior] [varchar](50) NULL,
	[FechaOperacionAnterior] [date] NULL,
	[PedimentoOriginal] [varchar](50) NULL,
	[PatenteAduanalOrig] [varchar](50) NULL,
	[SeccionAduaneraDespOrig] [varchar](50) NULL,
	[FechaPagoReal] [datetime] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
