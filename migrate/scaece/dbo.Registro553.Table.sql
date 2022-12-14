/****** Object:  Table [dbo].[Registro553]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro553](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[Fraccion] [varchar](8) NULL,
	[SecuenciaFraccion] [varchar](50) NULL,
	[ClavePermiso] [varchar](3) NULL,
	[FirmaDescargo] [varchar](40) NULL,
	[NumeroPermiso] [varchar](25) NULL,
	[ValorComercialDolares] [varchar](50) NULL,
	[CantidadMUMTarifa] [varchar](50) NULL,
	[FechaPagoReal] [varchar](50) NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Datastage_id] [int] NULL,
	[Consulta] [varchar](50) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
