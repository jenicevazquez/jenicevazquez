/****** Object:  Table [dbo].[listadoEdocuments]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[listadoEdocuments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pedimento] [varchar](50) NULL,
	[documento] [varchar](50) NULL,
	[completo] [int] NULL CONSTRAINT [DF_listadoEdocuments_completo]  DEFAULT ((0)),
	[id_pedimento] [int] NULL,
	[aduana] [varchar](50) NULL,
	[patente] [varchar](50) NULL,
	[procesado] [int] NULL CONSTRAINT [DF_listadoEdocuments_procesando]  DEFAULT ((0)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[fecha] [date] NULL,
	[licencia] [int] NULL,
	[respuesta] [varchar](500) NULL,
	[vucem_id] [int] NULL,
	[acuse] [int] NULL CONSTRAINT [DF_listadoEdocuments_acuse]  DEFAULT ((0))
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
