/****** Object:  Table [dbo].[Registro505]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro505](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[FechaFacturacion] [date] NULL,
	[NumeroFactura] [varchar](40) NULL,
	[TerminoFacturacion] [varchar](3) NULL,
	[MonedaFacturacion] [varchar](3) NULL,
	[ValorDolares] [decimal](16, 2) NULL,
	[ValorMonedaExtranjera] [decimal](16, 2) NULL,
	[PaisFacturacion] [varchar](3) NULL,
	[EntidadFedFacturacion] [varchar](3) NULL,
	[IndentFiscalProveedor] [varchar](30) NULL,
	[ProveedorMercancia] [varchar](120) NULL,
	[CalleProveedor] [varchar](80) NULL,
	[NumInteriorProveedor] [varchar](10) NULL,
	[NumExteriorProveedor] [varchar](10) NULL,
	[CpProveedor] [varchar](10) NULL,
	[MunicipioProveedor] [varchar](80) NULL,
	[FechaPagoReal] [varchar](50) NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL,
	[Patente] [varchar](50) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
