/****** Object:  Table [dbo].[partidas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[partidas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[numero] [int] NULL,
	[fraccion] [varchar](8) NULL,
	[subdivision] [varchar](3) NULL,
	[descripcion] [varchar](250) NULL,
	[umt] [int] NULL,
	[cantidadumt] [decimal](18, 6) NULL,
	[cantidadumc] [decimal](18, 6) NULL,
	[valorcomercial] [decimal](18, 2) NULL,
	[preciounitario] [decimal](18, 2) NULL,
	[valordolares] [decimal](18, 2) NULL,
	[valoraduana] [decimal](18, 2) NULL,
	[codigo] [varchar](20) NULL,
	[valoragregado] [decimal](18, 2) NULL,
	[modelo] [varchar](80) NULL,
	[marca] [varchar](80) NULL,
	[vinculacion] [varchar](250) NULL,
	[metodo] [varchar](250) NULL,
	[paisorigen] [varchar](3) NULL,
	[umc] [int] NULL,
	[paisvendedor] [varchar](3) NULL,
	[pedimento_id] [int] NULL,
	[observaciones] [text] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_partidas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
