/****** Object:  Table [dbo].[listadoPartidas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[listadoPartidas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pedimento] [varchar](50) NULL,
	[partida] [varchar](50) NULL,
	[completo] [int] NULL CONSTRAINT [DF_listadoPartidas_completo]  DEFAULT ((0)),
	[aduana] [varchar](50) NULL,
	[patente] [varchar](50) NULL,
	[operacion] [varchar](50) NULL,
	[id_pedimento] [int] NULL,
	[procesado] [int] NULL CONSTRAINT [DF_listadoPartidas_procesando]  DEFAULT ((0)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[licencia] [int] NULL,
	[fecha] [date] NULL,
	[resultado] [varchar](500) NULL,
	[vucem_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
