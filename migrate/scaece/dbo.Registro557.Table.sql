/****** Object:  Table [dbo].[Registro557]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro557](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](50) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](50) NULL,
	[Fraccion] [varchar](8) NULL,
	[SecuenciaFraccion] [varchar](50) NULL,
	[ClaveContribucion] [varchar](2) NULL,
	[FormaPago] [varchar](3) NULL,
	[ImportePago] [varchar](12) NULL,
	[FechaPagoReal] [datetime] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Datastage_id] [int] NULL,
	[Consulta] [varchar](50) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
