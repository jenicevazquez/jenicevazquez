/****** Object:  Table [dbo].[tasagravamen]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tasagravamen](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [int] NULL,
	[tasaAplicable] [decimal](18, 2) NULL,
	[gravamen_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_tasagravamen] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
