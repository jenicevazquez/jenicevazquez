/****** Object:  Table [dbo].[claveEdocuments]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[claveEdocuments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [varchar](50) NULL,
	[documento] [varchar](250) NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
