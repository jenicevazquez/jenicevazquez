/****** Object:  Table [dbo].[pedimentos]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[pedimentos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[patente] [varchar](50) NULL,
	[pedimento] [varchar](50) NULL,
	[aduana] [varchar](50) NULL,
	[operacion] [varchar](1) NULL,
	[clave] [varchar](50) NULL,
	[fechapago] [date] NULL,
	[contribuyente] [varchar](50) NULL,
	[agente] [varchar](50) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[porcentaje] [decimal](18, 0) NULL CONSTRAINT [DF_pedimentos_porcentaje]  DEFAULT ((0)),
	[created_by] [int] NULL,
	[alerta] [int] NULL CONSTRAINT [DF_pedimentos_alerta]  DEFAULT ((1)),
	[licencia] [int] NULL,
	[contingencia] [int] NOT NULL CONSTRAINT [DF_pedimentos_contingencia]  DEFAULT ((0)),
	[vu] [decimal](18, 0) NULL CONSTRAINT [DF_pedimentos_vu]  DEFAULT ((0)),
	[filesize] [int] NULL,
	[updated_by] [varchar](50) NULL,
	[seccion] [varchar](50) NULL,
	[af] [varchar](1) NOT NULL CONSTRAINT [DF_pedimentos_af]  DEFAULT ('N'),
	[actualizado] [int] NULL,
	[procesando] [int] NULL CONSTRAINT [DF_pedimentos_procesando]  DEFAULT ((0)),
	[destino] [int] NULL,
	[tipocambio] [decimal](18, 3) NULL,
	[pesobruto] [decimal](18, 3) NULL,
	[mediosalida] [int] NULL,
	[medioarriba] [int] NULL,
	[medioentrada] [int] NULL,
	[curpapoderado] [varchar](20) NULL,
	[rfcagente] [varchar](20) NULL,
	[valordolares] [decimal](18, 2) NULL,
	[valoraduanal] [decimal](18, 2) NULL,
	[valorcomercial] [decimal](18, 2) NULL,
	[observaciones] [text] NULL,
	[captura] [varchar](50) NULL,
	[numeroOperacion] [varchar](50) NULL,
	[rectificacion] [int] NULL CONSTRAINT [DF_pedimentos_rectificacion]  DEFAULT ((0)),
	[lock] [int] NULL CONSTRAINT [DF_pedimentos_lock]  DEFAULT ((0)),
	[horapago] [time](0) NULL,
 CONSTRAINT [PK_pedimentos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
