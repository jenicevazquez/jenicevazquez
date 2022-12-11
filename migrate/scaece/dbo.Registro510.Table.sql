/****** Object:  Table [dbo].[Registro510]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro510](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[ClaveContribucion] [varchar](2) NULL,
	[TasaContribucion] [varchar](50) NULL,
	[TipoTasa] [varchar](50) NULL,
	[TipoPedimento] [varchar](50) NULL,
	[FechaPagoReal] [varchar](50) NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Datastage_id] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[FormaPago] [varchar](3) NULL,
	[ImportePago] [varchar](12) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
