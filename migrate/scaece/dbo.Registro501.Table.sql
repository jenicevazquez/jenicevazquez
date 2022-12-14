/****** Object:  Table [dbo].[Registro501]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro501](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](4) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](3) NULL,
	[TipoOperacion] [varchar](1) NULL,
	[ClaveDocumento] [varchar](2) NULL,
	[SeccionAduaneraEntrada] [varchar](3) NULL,
	[CurpContribuyente] [varchar](18) NULL,
	[Rfc] [varchar](13) NULL,
	[CurpAgenteA] [varchar](18) NULL,
	[TipoCambio] [decimal](9, 5) NULL,
	[TotalFletes] [varchar](12) NULL,
	[TotalSeguros] [varchar](12) NULL,
	[TotalEmbalajes] [varchar](12) NULL,
	[TotalIncrementables] [varchar](12) NULL,
	[TotalDeducibles] [varchar](12) NULL,
	[PesoBrutoMercancia] [decimal](17, 3) NULL,
	[MedioTransporteSalida] [varchar](2) NULL,
	[MedioTransporteArribo] [varchar](2) NULL,
	[MedioTransporteEntrada_Salida] [varchar](2) NULL,
	[DestinoMercancia] [varchar](2) NULL,
	[NombreContribuyente] [varchar](120) NULL,
	[CalleContribuyente] [varchar](80) NULL,
	[NumInteriorContribuyente] [varchar](10) NULL,
	[NumExteriorContribuyente] [varchar](10) NULL,
	[CPContribuyente] [varchar](10) NULL,
	[MunicipioContribuyente] [varchar](80) NULL,
	[EntidadFedContribuyente] [varchar](3) NULL,
	[PaisContribuyente] [varchar](3) NULL,
	[TipoPedimento] [varchar](50) NULL,
	[FechaRecepcionPedimento] [datetime] NULL,
	[FechaPagoReal] [datetime] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
