/****** Object:  Table [dbo].[covesdomicilios]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[covesdomicilios](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[calle] [varchar](255) NULL,
	[numeroExterior] [varchar](50) NULL,
	[numeroInterior] [varchar](50) NULL,
	[colonia] [varchar](50) NULL,
	[localidad] [varchar](50) NULL,
	[municipio] [varchar](50) NULL,
	[entidadFederativa] [varchar](50) NULL,
	[pais] [varchar](50) NULL,
	[codigoPostal] [varchar](50) NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
