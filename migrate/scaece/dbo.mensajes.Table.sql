/****** Object:  Table [dbo].[mensajes]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mensajes](
	[id] [int] NOT NULL,
	[fecha] [datetime] NULL,
	[de] [int] NULL,
	[para] [int] NULL,
	[mensaje] [text] NULL,
	[licencia] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
