/****** Object:  Table [dbo].[users]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[email] [nvarchar](255) NOT NULL,
	[password] [varchar](1000) NOT NULL,
	[imagen] [varchar](50) NULL,
	[remember_token] [nvarchar](100) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[licencia_id] [int] NULL,
	[admin] [int] NULL,
	[role_id] [int] NULL,
	[titular] [int] NULL,
	[contribuyente] [int] NULL,
	[created_by] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
