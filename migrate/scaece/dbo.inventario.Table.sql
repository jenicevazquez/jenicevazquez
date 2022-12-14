/****** Object:  Table [dbo].[inventario]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[inventario](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [varchar](2) NULL,
	[patente] [varchar](4) NULL,
	[pedimento] [varchar](7) NULL,
	[seccion] [varchar](3) NULL,
	[fechaEntrada] [date] NULL,
	[fraccion] [varchar](8) NULL,
	[valorComercial] [float] NULL,
	[identificador] [varchar](1) NULL,
	[sustituir] [varchar](24) NULL,
	[id_inventario] [int] NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
