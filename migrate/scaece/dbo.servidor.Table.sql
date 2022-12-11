/****** Object:  Table [dbo].[servidor]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[servidor](
	[id] [int] NOT NULL,
	[nombre] [varchar](50) NULL,
	[comando] [varchar](1000) NULL,
	[porcentaje] [int] NULL,
	[creacion] [datetime] NULL,
	[actualizacion] [datetime] NULL,
	[licencia] [int] NULL,
	[resultado] [text] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
