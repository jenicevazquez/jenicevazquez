/****** Object:  Table [dbo].[regimenes]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[regimenes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clavepedimento] [varchar](50) NULL,
	[regimenpedimento] [varchar](50) NULL,
	[tipo] [varchar](50) NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
