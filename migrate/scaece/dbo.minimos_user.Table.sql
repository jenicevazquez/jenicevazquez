/****** Object:  Table [dbo].[minimos_user]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[minimos_user](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[minimo_id] [int] NULL,
	[orden] [int] NULL,
	[licencia_id] [int] NULL,
	[updated_at] [datetime] NULL,
	[created_at] [datetime] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_minimos_user] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
