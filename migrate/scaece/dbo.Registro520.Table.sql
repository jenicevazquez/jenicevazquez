/****** Object:  Table [dbo].[Registro520]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro520](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[IndentFiscalDestinatario] [varchar](17) NULL,
	[NombreDestinatarioMercancia] [varchar](120) NULL,
	[CalleDestinatario] [varchar](80) NULL,
	[NumInteriorDestinatario] [varchar](10) NULL,
	[NumExteriorDestinatario] [varchar](10) NULL,
	[CpDestinatario] [varchar](10) NULL,
	[MunicpioDestinatario] [varchar](80) NULL,
	[PaisDestinatario] [varchar](3) NULL,
	[FechaPagoReal] [varchar](50) NULL,
	[Licencia] [int] NULL,
	[Created_at] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL,
	[Created_by] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
