/****** Object:  Table [dbo].[listadoFechas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[listadoFechas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[consulta] [varchar](50) NULL,
	[fecha] [date] NULL,
	[completo] [int] NULL CONSTRAINT [DF_listadoFechas_completo]  DEFAULT ((0)),
	[aduana] [varchar](3) NULL,
	[pedimentos] [int] NULL,
	[procesado] [int] NULL CONSTRAINT [DF_listadoFechas_procesando]  DEFAULT ((0)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[licencia] [int] NULL,
	[vucem_id] [int] NULL,
	[tipoconsulta] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
