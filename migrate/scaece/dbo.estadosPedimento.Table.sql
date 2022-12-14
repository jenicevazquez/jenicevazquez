/****** Object:  Table [dbo].[estadosPedimento]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[estadosPedimento](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[estado] [int] NULL,
	[descripcion] [varchar](30) NULL,
	[subestado] [int] NULL,
	[descripcionsubestado] [varchar](60) NULL,
	[secuencia] [int] NULL,
	[factura] [varchar](13) NULL,
	[cantidad] [decimal](18, 6) NULL,
	[valor] [decimal](18, 2) NULL,
	[detalle_id] [int] NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_estadosPedimento] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
