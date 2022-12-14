/****** Object:  Table [dbo].[Registro551]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro551](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[Fraccion] [varchar](8) NULL,
	[SecuenciaFraccion] [varchar](50) NULL,
	[SubdivisionFraccion] [varchar](8) NULL,
	[DescripcionMercancia] [varchar](250) NULL,
	[PrecioUnitario] [decimal](21, 5) NULL,
	[ValorAduana] [varchar](12) NULL,
	[ValorComercial] [varchar](12) NULL,
	[ValorDolares] [decimal](16, 2) NULL,
	[CantidadUMComercial] [decimal](18, 3) NULL,
	[UnidadMedidaComercial] [varchar](2) NULL,
	[CantidadUMTarifa] [decimal](23, 5) NULL,
	[UnidadMedidaTarifa] [varchar](2) NULL,
	[ValorAgregado] [varchar](12) NULL,
	[ClaveVinculacion] [varchar](1) NULL,
	[MetodoValorizacion] [varchar](2) NULL,
	[CodigoMercanciaProducto] [varchar](20) NULL,
	[MarcaMercanciaProducto] [varchar](80) NULL,
	[ModeloMercanciaProducto] [varchar](80) NULL,
	[PaisOrigenDestino] [varchar](3) NULL,
	[PaisCompradorVendedor] [varchar](3) NULL,
	[EntidadFedOrigen] [varchar](3) NULL,
	[EntidadFedComprador] [varchar](3) NULL,
	[EntidadFedVendedor] [varchar](3) NULL,
	[TipoOperacion] [varchar](50) NULL,
	[ClaveDocumento] [varchar](50) NULL,
	[FechaPagoReal] [datetime] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL,
	[EntidadFedDestino] [varchar](50) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
