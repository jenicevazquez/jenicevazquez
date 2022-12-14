/****** Object:  Table [dbo].[empresas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[empresas](
	[id] [int] NOT NULL,
	[empresa] [varchar](50) NULL,
	[usuarios] [int] NULL,
	[inicia] [date] NULL,
	[vence] [date] NULL,
	[activo] [int] NULL,
	[observaciones] [varchar](255) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[paquete_id] [int] NULL,
	[tipo] [int] NULL,
	[ruta] [varchar](1000) NULL,
	[token] [varchar](50) NULL,
	[logo] [varchar](500) NULL,
	[publico] [int] NULL,
	[iniciado] [int] NOT NULL,
	[capacidad] [bigint] NULL,
	[credenciales] [int] NULL,
	[cliente_id] [int] NULL,
	[licencia_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
