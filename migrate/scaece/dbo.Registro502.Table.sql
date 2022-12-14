/****** Object:  Table [dbo].[Registro502]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro502](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[RfcTransportista] [varchar](13) NULL,
	[CurpTransportista] [varchar](18) NULL,
	[NombreTransportista] [varchar](120) NULL,
	[PaisTransporte] [varchar](3) NULL,
	[IdentificadorTransporte] [varchar](17) NULL,
	[FechaPagoReal] [date] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[Datastage_id] [int] NULL,
	[Patente] [varchar](50) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
