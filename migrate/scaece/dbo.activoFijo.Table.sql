/****** Object:  Table [dbo].[activoFijo]    Script Date: 19/09/2019 01:38:21 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[activoFijo](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[descripcionGenerica] [varchar](255) NULL,
	[claveUnidadMedida] [varchar](50) NULL,
	[tipoMoneda] [varchar](50) NULL,
	[cantidad] [float] NULL,
	[marca] [varchar](50) NULL,
	[modelo] [varchar](50) NULL,
	[numeroSerie] [varchar](50) NULL,
	[idpedimento] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[licencia] [int] NULL,
	[valorUnitario] [float] NULL,
	[valorTotal] [float] NULL,
	[valorDolares] [float] NULL,
	[planta] [varchar](255) NULL,
	[seccion] [varchar](255) NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
