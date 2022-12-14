/****** Object:  Table [dbo].[Registro500]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Registro500](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Patente] [varchar](4) NULL,
	[Pedimento] [varchar](7) NULL,
	[SeccionAduanera] [varchar](3) NULL,
	[ConsecutivoRemesa] [varchar](50) NULL,
	[NumeroSeleccion] [varchar](50) NULL,
	[FechaInicioReconocimiento] [date] NULL,
	[HoraInicioReconocimiento] [time](7) NULL,
	[FechaFinReconocimiento] [date] NULL,
	[HoraFinReconocimiento] [time](7) NULL,
	[Fraccion] [varchar](50) NULL,
	[SecuenciaFraccion] [varchar](50) NULL,
	[ClaveDocumento] [varchar](50) NULL,
	[TipoOperacion] [varchar](50) NULL,
	[GradoIncidencia] [varchar](50) NULL,
	[FechaSeleccion] [date] NULL,
	[Licencia] [int] NULL,
	[Created_by] [int] NULL,
	[Consulta] [varchar](50) NULL,
	[datastage_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
