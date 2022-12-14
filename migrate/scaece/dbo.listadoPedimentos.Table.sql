/****** Object:  Table [dbo].[listadoPedimentos]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[listadoPedimentos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[aduana] [varchar](50) NULL,
	[patente] [varchar](50) NULL,
	[pedimento] [varchar](50) NULL,
	[completo] [int] NULL CONSTRAINT [DF_listadoPedimentos_completo]  DEFAULT ((0)),
	[remesas] [int] NULL CONSTRAINT [DF_listadoPedimentos_remesas]  DEFAULT ((0)),
	[estado] [int] NULL CONSTRAINT [DF_listadoPedimentos_estado]  DEFAULT ((0)),
	[operacion] [varchar](50) NULL,
	[id_pedimento] [int] NULL,
	[procesado] [int] NOT NULL CONSTRAINT [DF_listadoPedimentos_procesando]  DEFAULT ((0)),
	[seccion] [varchar](50) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[licencia] [int] NULL,
	[fecha] [date] NULL,
	[resCompleto] [varchar](500) NULL,
	[resRemesas] [varchar](500) NULL,
	[resEstado] [varchar](500) NULL,
	[vucem_id] [int] NULL,
	[procesadoEstado] [int] NULL CONSTRAINT [DF_listadoPedimentos_procesadoEstado]  DEFAULT ((0)),
	[procesadoRemesa] [int] NULL CONSTRAINT [DF_listadoPedimentos_procesadoRemesa]  DEFAULT ((0))
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
