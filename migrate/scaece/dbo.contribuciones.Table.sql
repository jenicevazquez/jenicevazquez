/****** Object:  Table [dbo].[contribuciones]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[contribuciones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [int] NULL,
	[contribucion] [varchar](100) NULL,
	[abreviacion] [varchar](10) NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
