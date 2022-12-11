/****** Object:  Table [dbo].[datastage]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[datastage](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[archivo] [varchar](800) NULL,
	[creado] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[hash] [varchar](50) NULL,
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
